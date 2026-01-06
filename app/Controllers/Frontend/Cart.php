<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\CartModel;
use App\Models\EnrollmentModel;

class Cart extends BaseController
{
    /* =========================
       VIEW CART
    ========================= */
    public function index()
    {
        if (!session()->get('user_logged_in')) {
            session()->set('redirect_after_login', base_url('cart'));
            return redirect()->to('/auth');
        }

        $userId = session()->get('user_id');

        $cartModel   = new CartModel();
        $enrollModel = new EnrollmentModel();

        $cartItems = $cartModel
            ->select('cart_items.*, products.plan_name, products.chit_amount')
            ->join('products', 'products.id = cart_items.product_id')
            ->where('cart_items.user_id', $userId)
            ->findAll();

        // ✅ ADD ENROLLED SLOTS INFO
        foreach ($cartItems as &$item) {
            $item['enrolled_slots'] = $enrollModel
                ->where('user_id', $userId)
                ->where('product_id', $item['product_id'])
                ->countAllResults();
        }

        $totalSlots = array_sum(array_column($cartItems, 'slots'));

        return view('frontend/pages/cart', [
            'cartItems'  => $cartItems,
            'totalSlots' => $totalSlots
        ]);
    }

    /* =========================
       ADD TO CART
    ========================= */
    public function add()
    {
        if (!session()->get('user_logged_in')) {
            session()->set(
                'redirect_after_login',
                $this->request->getPost('redirect_url') ?? previous_url()
            );
            return redirect()->to('/auth');
        }

        $userId    = session()->get('user_id');
        $productId = (int) $this->request->getPost('product_id');
        $slotsReq  = (int) $this->request->getPost('slots');

        if ($productId <= 0 || $slotsReq < 1 || $slotsReq > 2) {
            return redirect()->back()->with('error', 'Invalid slot selection');
        }

        $product = (new ProductModel())
            ->where('id', $productId)
            ->where('status', 1)
            ->first();

        if (!$product) {
            return redirect()->back()->with('error', 'Plan not available');
        }

        $cartModel   = new CartModel();
        $enrollModel = new EnrollmentModel();

        $alreadyEnrolled = $enrollModel
            ->where('user_id', $userId)
            ->where('product_id', $productId)
            ->countAllResults();

        if (($alreadyEnrolled + $slotsReq) > 2) {
            return redirect()->back()
                ->with('error', 'You can enroll maximum 2 slots per plan');
        }

        $existing = $cartModel
            ->where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($existing) {
            if (($existing['slots'] + $alreadyEnrolled + $slotsReq) > 2) {
                return redirect()->back()
                    ->with('error', 'Slot limit exceeded');
            }

            $cartModel->update($existing['id'], [
                'slots' => $existing['slots'] + $slotsReq
            ]);
        } else {
            $cartModel->insert([
                'user_id'    => $userId,
                'product_id' => $productId,
                'slots'      => $slotsReq,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }

        return redirect()->to(
            $this->request->getPost('redirect_url') ?? base_url('cart')
        )->with('success', 'Added to savings bag');
    }

    /* =========================
       UPDATE SLOT COUNT
    ========================= */
    public function updateSlots()
    {
        if (!session()->get('user_logged_in')) {
            return redirect()->to('/auth');
        }

        $cartId = (int) $this->request->getPost('cart_id');
        $action = $this->request->getPost('action');
        $userId = session()->get('user_id');

        $cartModel   = new CartModel();
        $enrollModel = new EnrollmentModel();

        $item = $cartModel->find($cartId);

        if (!$item || $item['user_id'] != $userId) {
            return redirect()->back();
        }

        $enrolledSlots = $enrollModel
            ->where('user_id', $userId)
            ->where('product_id', $item['product_id'])
            ->countAllResults();

        $slots = $item['slots'];

        if ($action === 'increase' && ($slots + $enrolledSlots) < 2) {
            $slots++;
        }

        if ($action === 'decrease' && $slots > 1) {
            $slots--;
        }

        $cartModel->update($cartId, ['slots' => $slots]);

        return redirect()->to('/cart');
    }

    /* =========================
       REMOVE ITEM
    ========================= */
    public function remove($id)
    {
        if (!session()->get('user_logged_in')) {
            return redirect()->to('/auth');
        }

        $cartModel = new CartModel();
        $item = $cartModel->find($id);

        if ($item && $item['user_id'] == session()->get('user_id')) {
            $cartModel->delete($id);
        }

        return redirect()->back();
    }
}
