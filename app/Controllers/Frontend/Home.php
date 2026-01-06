<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Models\SiteSettingModel;
use App\Models\ProductModel;
use App\Models\EnrollmentModel;

class Home extends BaseController
{
    public function index()
    {
        // =========================
        // LOAD MODELS
        // =========================
        $settingModel = new SiteSettingModel();
        $productModel = new ProductModel();
        $enrollModel  = new EnrollmentModel();

        // =========================
        // SITE SETTINGS (CMS)
        // =========================
        $settings = [];
        foreach ($settingModel->findAll() as $row) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }

        // =========================
        // FETCH OPEN PLANS ONLY
        // =========================
        $products = $productModel
            ->where('status', 1) // Open plans only
            ->orderBy('id', 'DESC')
            ->findAll();

        // =========================
        // ADD SLOT DATA (READ-ONLY, SAFE)
        // =========================
        foreach ($products as $key => $product) {

            // Count enrolled slots for this plan
            $filled = $enrollModel
                ->where('product_id', $product['id'])
                ->countAllResults(true); // reset builder safely

            // Attach computed values (NOT stored in DB)
            $products[$key]['filled_slots'] = $filled;
            $products[$key]['slots_available'] = max(
                0,
                $product['total_members'] - $filled
            );
        }

        // =========================
        // LOAD VIEW
        // =========================
        return view('frontend/pages/home', [
            'settings' => $settings,
            'products' => $products
        ]);
    }
}
