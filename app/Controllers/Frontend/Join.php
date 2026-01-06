<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\CartModel;
use App\Models\EnrollmentModel;
use CodeIgniter\Database\Exceptions\DatabaseException;

class Join extends BaseController
{
    /* =========================
       CONFIRM ENROLLMENT
    ========================= */
    public function confirm()
    {
        /* -------------------------
           LOGIN CHECK
        ------------------------- */
        if (!session()->get('user_logged_in')) {
            session()->set('redirect_after_login', base_url('cart'));
            return redirect()->to('/auth');
        }

        $userId   = (int) session()->get('user_id');
        $userName = session()->get('user_name');

        $cartModel    = new CartModel();
        $productModel = new ProductModel();
        $enrollModel  = new EnrollmentModel();
        $db           = \Config\Database::connect();

        /* -------------------------
           FETCH CART
        ------------------------- */
        $cartItems = $cartModel
            ->where('user_id', $userId)
            ->findAll();

        if (empty($cartItems)) {
            return redirect()->to('/cart')
                ->with('error', 'Your cart is empty');
        }

        /* -------------------------
           TRANSACTION START
        ------------------------- */
        $db->transBegin();

        try {

            foreach ($cartItems as $item) {

                $productId = (int) $item['product_id'];
                $slotsReq  = (int) $item['slots'];

                /* -------------------------
                   LOCK PRODUCT
                ------------------------- */
                $product = $db->query(
                    "SELECT * FROM products WHERE id = ? AND status = 1 FOR UPDATE",
                    [$productId]
                )->getRowArray();

                if (!$product) {
                    throw new DatabaseException('Plan not available');
                }

                /* -------------------------
                   COUNT CURRENT ENROLLMENTS
                ------------------------- */
                $totalFilled = $enrollModel
                    ->where('product_id', $productId)
                    ->countAllResults();

                $userEnrolled = $enrollModel
                    ->where('product_id', $productId)
                    ->where('user_id', $userId)
                    ->countAllResults();

                /* -------------------------
                   VALIDATIONS
                ------------------------- */
                if (($totalFilled + $slotsReq) > $product['total_members']) {
                    throw new DatabaseException(
                        'Not enough slots available for ' . $product['plan_name']
                    );
                }

                if (($userEnrolled + $slotsReq) > 2) {
                    throw new DatabaseException(
                        'Maximum 2 slots per plan allowed'
                    );
                }

                /* -------------------------
                   INSERT ENROLLMENTS
                   (1 ROW = 1 SLOT)
                ------------------------- */
                for ($i = 1; $i <= $slotsReq; $i++) {
                    $enrollModel->insert([
                        'user_id'      => $userId,
                        'user_name'    => $userName,
                        'product_id'   => $productId,
                        'product_name' => $product['plan_name'],
                        'plan_amount'  => $product['chit_amount'],
                        'slot_uid'     => uniqid('SLOT-'),
                        'enrolled_at'  => date('Y-m-d H:i:s')
                    ]);
                }

                /* -------------------------
                   AUTO UPDATE PRODUCT STATUS
                ------------------------- */
                if (($totalFilled + $slotsReq) >= $product['total_members']) {
                    $productModel->update($productId, [
                        'status' => 2 // Slots Full
                    ]);
                }
            }

            /* -------------------------
               CLEAR CART
            ------------------------- */
            $cartModel->where('user_id', $userId)->delete();

            $db->transCommit();

        } catch (\Throwable $e) {

            $db->transRollback();

            return redirect()->to('/cart')
                ->with('error', $e->getMessage());
        }

        /* -------------------------
           SUCCESS
        ------------------------- */
        return redirect()->to('/my-enrollments')
            ->with('success', 'Enrollment completed successfully');
    }
}
