</div>
</div>
<script>
    // --- Skrip untuk Sidebar Toggle ---
    const toggleButton = document.getElementById('sidebar-toggle');
    const sidebar = document.getElementById('sidebar');
    if (toggleButton && sidebar) {
        toggleButton.addEventListener('click', () => {
            sidebar.classList.toggle('closed');
        });
    }

    // --- Skrip untuk Submenu Data Master ---
    const dataMasterMenu = document.getElementById('data-master-menu');
    const dataMasterSubmenu = document.getElementById('data-master-submenu');
    if (dataMasterMenu && dataMasterSubmenu) {
        dataMasterMenu.addEventListener('click', function(event) {
            event.preventDefault();
            dataMasterSubmenu.style.display = (dataMasterSubmenu.style.display === 'none' ? 'block' : 'none');
            dataMasterMenu.classList.toggle('open');
        });
    }

    // --- Skrip untuk Submenu Data Cuti ---
    const dataCutiMenu = document.getElementById('data-cuti-menu');
    const dataCutiSubmenu = document.getElementById('data-cuti-submenu');
    if (dataCutiMenu && dataCutiSubmenu) {
        dataCutiMenu.addEventListener('click', function(event) {
            event.preventDefault();
            dataCutiSubmenu.style.display = (dataCutiSubmenu.style.display === 'none' ? 'block' : 'none');
            dataCutiMenu.classList.toggle('open');
        });
    }
</script>
</body>

</html>