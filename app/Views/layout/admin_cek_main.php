<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($page_title ?? 'Djaya Aspalt Admin') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #F0F2F5; }
        .admin-wrapper { display: flex; }
        .admin-sidebar {
            width: 250px; min-height: 100vh; background-color: #ffffff;
            padding-top: 1.5rem; position: fixed; height: 100%;
            border-right: 1px solid #e0e0e0;
        }
        .sidebar-header { padding: 0 1.5rem; margin-bottom: 2rem; }
        .sidebar-header a { text-decoration: none; color: black; display: flex; align-items: center; }
        .sidebar-header img.back-icon { width: 32px; height: 32px; margin-right: 10px; }
        .sidebar-header h5 { margin: 0; font-weight: 600; }
        .admin-main-content-wrapper { margin-left: 250px; width: calc(100% - 250px); }
        .admin-topbar {
            background-color: #ffffff; padding: 1rem 2rem;
            border-bottom: 1px solid #e0e0e0;
            display: flex; justify-content: flex-end; align-items: center; height: 70px;
        }
        .topbar-logo img { height: 40px; }
        .admin-main-content { padding: 2rem; background-color: #FFDAB9; min-height: calc(100vh - 70px); }
        .admin-card {
            background: white; border-radius: 15px; padding: 20px;
            text-align: center; box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="admin-wrapper">
        <div class="admin-sidebar">
            <div class="sidebar-header">
                <a href="javascript:history.back()">
                    <img src="<?= base_url('assets/Back-01.png') ?>" alt="Back" class="back-icon">
                    <h5><?= esc($page_title ?? 'Kembali') ?></h5>
                </a>
            </div>
        </div>
        <div class="admin-main-content-wrapper">
            <div class="admin-topbar">
                <div class="topbar-logo">
                    <img src="<?= base_url('assets/logo_djaya_aspalt_text.png') ?>" alt="Logo Djaya Aspalt">
                </div>
            </div>
            <div class="admin-main-content">
                <?= $this->renderSection('content') ?>
            </div>
        </div>
    </div>
</body>
</html>