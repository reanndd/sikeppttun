</div>
</div>
        <script>
            const toggleButton = document.getElementById('sidebar-toggle');
            const sidebar = document.getElementById('sidebar');

            toggleButton.addEventListener('click', () => {
                sidebar.classList.toggle('closed');
            });

            const dataMasterMenu = document.getElementById('data-master-menu');
            const dataMasterSubmenu = document.getElementById('data-master-submenu');

            dataMasterMenu.addEventListener('click', function(event) {
                event.preventDefault();
                if (dataMasterSubmenu.style.display === 'none') {
                    dataMasterSubmenu.style.display = 'block';
                } else {
                    dataMasterSubmenu.style.display = 'none';
                }
            });
        </script>
</body>

</html>