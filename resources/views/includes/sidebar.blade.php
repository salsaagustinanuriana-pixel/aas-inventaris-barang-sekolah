<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

    <div class="app-brand demo">
        <a href="index.html" class="app-brand-link">
            <span class="app-brand-logo demo">
                <i class="bx bx-book bx-ms"></i>
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-1">barang sekolah</span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    

        

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item ">
            <a href="dashboard2" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

    

          <li class="menu-item">
              <a href="{{ route('kategoribarang.index') }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-category"></i>
                  <div>Kategori Barang</div>
              </a>
          </li>

           <li class="menu-item">
         <a href="{{ route('barang.index') }}" class="menu-link">
             <i class="menu-icon tf-icons bx bx-box"></i>
             <div>Barang</div>
         </a>
     </li>
    
        <li class="menu-item">
            <a href="{{ route('transaksi.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-transfer"></i>
                <div>Transaksi</div>
            </a>
        </li>

      

    

           

</aside>
