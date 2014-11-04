<form class="form-horizontal" role="form" action="<?=APP_URL;?>/User/add" method="post">
    <div class="container-fluid">
        <div class="row">           
            <div class="col-sm-6">
                <div class="form-group <?=isset($invalid_input['email'])?'has-error':'';?>">
                    <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                        <input name="email" type="email" value="<?=isset($email)?$email:'';?>" class="form-control" id="inputEmail3" placeholder="Email">
                    </div>
                </div>
                <div class="form-group <?=isset($invalid_input['password'])?'has-error':'';?>">
                    <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-10">
                        <input name="password" type="password" class="form-control" id="inputPassword3" placeholder="Password">
                    </div>
                </div>
                <div class="form-group <?=isset($invalid_input['role'])?'has-error':'';?>">
                    <label for="inputRole3" class="col-sm-2 control-label">Role</label>
                    <div class="col-sm-10">
                        <select name="role" id="inputRole3" class="form-control">
                            <option value="user" <?=isset($role) && $role == 'user'?'selected' : '';?>>User</option>
                            <option value="editor" <?=isset($role) && $role == 'editor'?'selected' : '';?>>Editor</option>
                            <option value="administrator" <?=isset($role) && $role == 'administrator'?'selected' : '';?>>Administrator</option>
                            <option value="invalid" <?=isset($role) && $role == 'invalid'?'selected' : '';?>>Invalid</option>
                        </select>

                    </div>
                </div>

                <div class="form-group <?=isset($invalid_input['status'])?'has-error':'';?>">
                    <label for="inputStatus3" class="col-sm-2 control-label">Status</label>
                    <div class="col-sm-10">
                        <select name="status" id="inputStatus3" class="form-control">
                            <option value="active" <?=isset($status) && $status == 'active'?'selected' : '';?>>Active</option>
                            <option value="inactive" <?=isset($status) && $status == 'inactive'?'selected' : '';?>>Inactive</option>
                            <option value="invalid" <?=isset($status) && $status == 'invalid'?'selected' : '';?>>Invalid</option>
                        </select>

                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </div>
            </div>
            

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="inputNickName3" class="col-sm-4 control-label">Nick Name</label>
                    <div class="col-sm-8">
                        <input name="nickname" value="<?=isset($nickname)?$nickname:'';?>" type="text" class="form-control" id="inputNickName3" placeholder="Nick Name">
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputRealName3" class="col-sm-4 control-label">Real Name</label>
                    <div class="col-sm-8">
                        <input name="realname" value="<?=isset($realname)?$realname:'';?>" type="text" class="form-control" id="inputRealName3" placeholder="Real Name">
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputBibliography3" class="col-sm-4 control-label">Bibliography</label>
                    <div class="col-sm-8">
                        <textarea name="bio" rows="15" class="form-control" id="inputBibliography3" placeholder="Introduce yourself ..."><?=isset($bio)?$bio:'';?></textarea>

                    </div>
                </div>
                
            </div>
            
        </div>
    </div>
</form>


