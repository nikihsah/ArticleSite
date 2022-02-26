<section class="container-fluid">

    <div class="row mt-3 mb-3">
        <div class="col-sm-4" style="float: none; margin: 0 auto;">
            <h3 >Введите ваши данные</h3>
            <div class="text-danger">
                <?php
                if ($_POST['455']){
                    echo $_POST['455'];
                }
                ?>
            </div>
        </div>

    </div>

    <div class="row">
        <form class="form-group col-sm-4 col-centered" action="" method="POST" style="float: none; margin: 0 auto;">

            <div class="row mb-3">
                <label for="email" class="col-sm-2 col-form-label">Почта</label>
                <div class="col-sm-10">
                    <input class="form-control" placeholder="example@mail.com" name="email" type="text" required>
                </div>
            </div>

            <div class="row mb-3">
                <label for="username" class="col-sm-2 col-form-label">Логин</label>
                <div class="col-sm-10">
                    <input class="form-control" name="username" type="text" required>
                </div>
            </div>

            <div class="row mb-3">
                <label for="password" class="col-sm-2 col-form-label">Пароль</label>
                <div class="col-sm-10">
                    <input class="form-control" minlength="8" name="password" type="password" required>
                </div>
            </div>

            <div class="row mb-3">
                <input type="submit" class="btn btn-dark" value="Войти">
            </div>

        </form>
    </div>
</section>