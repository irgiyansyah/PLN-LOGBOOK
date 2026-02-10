<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
    
    :root {
        /* Warna PLN Blue */
        --pln-blue: #0ea5e9; 
    }

    body {
        font-family: 'Poppins', sans-serif !important;
        background-color: #f8fafc !important;
    }

    /* --- SIDEBAR (Kiri) --- */
    aside.fi-sidebar {
        background-color: white !important;
        border-right: 1px solid #e2e8f0 !important;
        box-shadow: 4px 0 24px rgba(0,0,0,0.02) !important;
    }

    /* Logo PLN LOGBOOK */
    .fi-logo {
        color: var(--pln-blue) !important;
        font-weight: 800 !important;
        font-size: 1.3rem !important;
    }

    /* MENU ITEM: NORMAL */
    .fi-sidebar-item {
        margin-bottom: 4px; /* Jarak antar menu */
    }
    
    .fi-sidebar-item > a {
        border-radius: 8px !important;
        padding: 10px 12px !important;
        transition: all 0.2s ease-in-out;
        font-weight: 500 !important;
        color: #64748b !important; /* Abu-abu */
    }

    /* MENU ITEM: HOVER (Saat mouse lewat) */
    .fi-sidebar-item > a:hover {
        background-color: #f0f9ff !important; /* Biru sangat muda */
        color: var(--pln-blue) !important;
    }

    /* MENU ITEM: ACTIVE (Yang sedang dipilih) */
    .fi-sidebar-item-active > a {
        background-color: var(--pln-blue) !important; /* Biru PLN Solid */
        color: white !important; /* Teks Putih */
        box-shadow: 0 4px 12px rgba(14, 165, 233, 0.3) !important;
    }

    /* Paksa Icon dan Teks jadi putih saat aktif */
    .fi-sidebar-item-active > a span,
    .fi-sidebar-item-active > a svg {
        color: white !important;
    }

    /* --- DASHBOARD CONTENT --- */
    /* Sembunyikan Navigasi User di Pojok Kanan Atas (karena sudah ada di bawah sidebar) */
    .fi-topbar nav .flex.items-center.gap-x-4 {
        opacity: 0; 
        pointer-events: none;
    }

    /* Tombol-tombol Dashboard */
    .fi-btn-primary {
        background-color: var(--pln-blue) !important;
        border: none !important;
    }
</style>