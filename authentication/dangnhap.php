<?php
include '../home/header.php';
?>
<title>Đăng nhập</title>

<div class="bg-gray-100 min-h-1 py-2 flex flex-col justify-center sm:py-12">
    <div class="relative py-3 sm:max-w-xl sm:mx-auto">
        <div class="absolute inset-0 bg-gradient-to-r from-yellow-400 to-yellow-600 shadow-lg transform -skew-y-6 sm:skew-y-0 sm:-rotate-6 sm:rounded-3xl"></div>
        <div class="relative px-4 py-10 bg-white shadow-lg sm:rounded-3xl sm:p-20">
            <div class="max-w-md mx-auto">
                <div>
                    <h1 class="text-2xl font-semibold text-center">Đăng nhập</h1>
                </div>
                <?php if (isset($_GET['error'])) { ?>
                    <div class="bg-red-200 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline"><?php echo $_GET['error']; ?></span>
                    </div>
                <?php } ?>
                <form action="dangnhap_check.php" method="post">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="Email">Email đăng nhập</label>
                    <input type="text" name="Email" id="Email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Email" value="<?php echo isset($_GET['Email']) ? $_GET['Email'] : ''; ?>">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="MatKhau">Mật khẩu</label>
                    <input type="password" name="MatKhau" id="MatKhau" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Mật khẩu">
                </div>
                <div class="mb-6">
                    <input type="submit" name="submit" class="bg-gray-900 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full" value="Đăng nhập" />
                </div>
            </form>
                <p class="text-center mt-4">Chưa có tài khoản? <a href="dangky.php" class="text-red-500 hover:text-red-700 font-bold">Đăng ký</a></p>
            </div>
        </div>
    </div>
</div>
<?php include '../home/footer.php' ?>
