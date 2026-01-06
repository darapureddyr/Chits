<div class="sidebar" id="sidebar">

    <ul class="sidebar-menu">

        <!-- DASHBOARD -->
        <li class="<?= ($activePage === 'dashboard') ? 'active' : '' ?>">
            <a href="<?= base_url('admin/dashboard') ?>">
                <span class="menu-text">Dashboard</span>
            </a>
        </li>

        <!-- PLANS -->
        <li class="<?= ($activePage === 'plans') ? 'active' : '' ?>">
            <a href="<?= base_url('admin/plans') ?>">
                <span class="menu-text">Plans</span>
            </a>
        </li>

        <!-- PLAN PAGE CONTENT -->
        <li class="<?= ($activePage === 'plan_page_content') ? 'active' : '' ?>">
            <a href="<?= base_url('admin/plan-page-content') ?>">
                <span class="menu-text">Plan Page Content</span>
            </a>
        </li>

    </ul>

</div>
