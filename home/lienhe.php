<title>Liên hệ</title>
<?php include 'header.php' ?>
        <div class="container mx-64 p-14">
        <h2 class="text-2xl font-bold mb-4">Liên hệ</h2>
        <form action="submit_contact.php" method="POST" class="space-y-4 contact-form">
        </form>
        <div class="mt-8 map-container">
            <div class="w-full h-96">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.457045874473!2d106.6781823153343!3d10.7768899923228!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f1b5a2b1b1b%3A0x2d9b1b1b1b1b1b1b!2s334%20T%C3%B4%20Hi%E1%BA%BFn%20Th%C3%A0nh%2C%20Ph%C6%B0%E1%BB%9Dng%2014%2C%20Qu%E1%BA%ADn%2010%2C%20Th%C3%A0nh%20ph%E1%BB%91%20H%E1%BB%93%20Ch%C3%AD%20Minh%2C%20Vietnam!5e0!3m2!1sen!2s!4v1683071234567!5m2!1sen!2s" 
                    width="100%" 
                    height="100%" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </div>
    <style>
        .contact-form {
            transition: transform 0.3s ease-in-out;
        }

        .contact-form:hover {
            transform: scale(1.02);
        }

        .map-container {
            transition: box-shadow 0.3s ease-in-out;
        }

        .map-container:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const button = document.getElementById('navbar-toggle');
            const menu = document.getElementById('navbar-dropdown');

            const dropdownButton = document.getElementById('dropdownNavbarLink');
            const dropdownMenu = document.getElementById('dropdownNavbar');

            if (dropdownButton && dropdownMenu) {
                dropdownButton.addEventListener('mouseenter', () => {
                    dropdownMenu.classList.remove('hidden');
                });

                dropdownButton.addEventListener('mouseleave', () => {
                    dropdownMenu.classList.add('hidden');
                });

                dropdownMenu.addEventListener('mouseenter', () => {
                    dropdownMenu.classList.remove('hidden');
                });

                dropdownMenu.addEventListener('mouseleave', () => {
                    dropdownMenu.classList.add('hidden');
                });
            }

            if (button && menu) {
                button.addEventListener('click', function() {
                    menu.classList.toggle('hidden');
                });
            }
        });
    </script>
<?php include 'footer.php' ?>