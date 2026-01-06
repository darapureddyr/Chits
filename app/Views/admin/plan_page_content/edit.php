<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<h2 class="page-title">Plan Page Content (CMS)</h2>

<form method="post" action="<?= base_url('admin/plan-page-content/update') ?>">

    <div class="form-grid">

        <div class="form-group">
            <label>Page Title (shown on plan page)</label>
            <input type="text"
                   name="plan_page_title"
                   value="<?= esc($content['plan_page_title'] ?? '') ?>">
        </div>

        <!-- 🔹 NEW: Chit Value Label -->
        <div class="form-group">
            <label>Chit Value Label</label>
            <input type="text"
                   name="chit_value_label"
                   placeholder="Ex: Chit Value / 1 Lakh Chit"
                   value="<?= esc($content['chit_value_label'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label>Duration Label</label>
            <input type="text"
                   name="duration_label"
                   value="<?= esc($content['duration_label'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label>Total Members Label</label>
            <input type="text"
                   name="total_members_label"
                   value="<?= esc($content['total_members_label'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label>Slot Info Text</label>
            <input type="text"
                   name="slot_info"
                   placeholder="Ex: Slots fill on first come basis"
                   value="<?= esc($content['slot_info'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label>Start Date Label</label>
            <input type="text"
                   name="start_date_label"
                   value="<?= esc($content['start_date_label'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label>Bid Date Label</label>
            <input type="text"
                   name="bid_date_label"
                   value="<?= esc($content['bid_date_label'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label>Bidding Info Text</label>
            <input type="text"
                   name="bidding_info"
                   placeholder="Ex: Bidding starts after slots are full"
                   value="<?= esc($content['bidding_info'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label>End Date Label</label>
            <input type="text"
                   name="end_date_label"
                   value="<?= esc($content['end_date_label'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label>Base Price Label</label>
            <input type="text"
                   name="base_price_label"
                   value="<?= esc($content['base_price_label'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label>Base Price Info</label>
            <input type="text"
                   name="base_price_info"
                   placeholder="Ex: Base amount may reduce based on bidding"
                   value="<?= esc($content['base_price_info'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label>Commission Label</label>
            <input type="text"
                   name="commission_label"
                   value="<?= esc($content['commission_label'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label>Commission Info</label>
            <input type="text"
                   name="commission_info"
                   placeholder="Ex: Fixed company commission every month"
                   value="<?= esc($content['commission_info'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label>Add To Cart Button Text</label>
            <input type="text"
                   name="add_to_cart_label"
                   value="<?= esc($content['add_to_cart_label'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label>Agree Checkbox Text</label>
            <input type="text"
                   name="agree_checkbox_text"
                   value="<?= esc($content['agree_checkbox_text'] ?? '') ?>">
        </div>

    </div>

    <div class="form-actions">
        <button type="submit" class="btn-primary">Save Changes</button>
    </div>

</form>

<?= $this->endSection() ?>
