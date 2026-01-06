<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>

<div class="plans-header">
    <h2><?= esc($title ?? 'Plans') ?></h2>

    <button id="openAddPlan" type="button" class="btn btn-primary">
        + Add Plan
    </button>
</div>

<div id="plansTable">
    <?php if (!empty($plans)): ?>
        <?= view('admin/plans/table', ['plans' => $plans]) ?>
    <?php else: ?>
        <p style="padding:15px;">No plans found</p>
    <?php endif; ?>
</div>

<div id="addPlanPanel" class="side-panel">
    <div class="panel-header">
        <h3>Add Plan</h3>
        <button id="closePanel" type="button">✕</button>
    </div>

    <?= view('admin/plans/add_form') ?>
</div>

<div id="panelOverlay" class="panel-overlay"></div>

<?= $this->endSection() ?>
