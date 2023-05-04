<div id="app" class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h2 class="text-center">Authorization</h2>
                    <h6><?=$data ?></h6>
                    <form action="" method="post">
                        <div class="form-row mt-3">
                            <label>Login: </label>
                            <input type="text" name="login" class="form-control field" required "/>
                        </div>
                        <div class="form-row mt-3">
                            <label>Password: </label>
                            <input type="password" name="password" class="form-control field" required "/>
                        </div>
                        <div class="form-row mt-3">
                            <input type="submit" class="form-control btn btn-primary btn-sm btn-block" value="ENTER SITE" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
