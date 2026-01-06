<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PlanPageContentModel;

class PlanPageContent extends BaseController
{
    /* =========================
     * ADMIN PROTECTION
     * ========================= */
    private function protect()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to(base_url('admin/login'));
        }
    }

    /* =========================
     * SHOW CMS EDIT PAGE
     * ========================= */
    public function index()
    {
        $this->protect();

        $model = new PlanPageContentModel();

        return view('admin/plan_page_content/edit', [
            'title'      => 'Plan Page Content',
            'activePage' => 'plan_page_content',
            'content'    => $model->first()
        ]);
    }

    /* =========================
     * UPDATE CMS CONTENT
     * ========================= */
    public function update()
    {
        $this->protect();

        $model   = new PlanPageContentModel();
        $content = $model->first();

        // ✅ Safe helper
        $input = fn ($key) => trim((string) $this->request->getPost($key));

        // ✅ CMS LABEL DATA
        $data = [
            'plan_page_title'      => $input('plan_page_title'),
            'chit_value_label'     => $input('chit_value_label'),
            'monthly_amount_label' => $input('monthly_amount_label'),
            'duration_label'       => $input('duration_label'),
            'total_members_label'  => $input('total_members_label'),
            'start_date_label'     => $input('start_date_label'),
            'bid_date_label'       => $input('bid_date_label'),
            'end_date_label'       => $input('end_date_label'),
            'base_price_label'     => $input('base_price_label'),
            'commission_label'     => $input('commission_label'),
            'add_to_cart_label'    => $input('add_to_cart_label'),
            'agree_checkbox_text'  => $input('agree_checkbox_text'),
        ];

        // ❌ Prevent empty CMS save
        foreach ($data as $key => $value) {
            if ($value === '') {
                return redirect()->back()
                    ->with('error', 'All CMS fields are required');
            }
        }

        // ✅ Update / Insert
        if ($content) {
            $model->update($content['id'], $data);
        } else {
            $model->insert($data);
        }

        return redirect()->back()->with(
            'success',
            'Plan page content updated successfully'
        );
    }
}
