<form class="form-horizontal" role="form" action="<?= APP_URL; ?>/Post/edit" method="post">

    <div class="container-fluid">

        <div class="form-group">
            <div class="col-sm-10">
                <input class="form-control" 
                       name="title" type="text" value="<?= isset($title) ? $title : ''; ?>" placeholder="Title">
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-10">
                <textarea class="form-control"
                          name="content" value="<?= isset($content) ? $content : ''; ?>"
                          row="25" col="80"
                          placeholder="Content ..."></textarea>
            </div>
        </div>


        <div class="form-group <?= isset($invalid_input['status']) ? 'has-error' : ''; ?>">
            <label for="inputRole3" class="control-label col-sm-1">Status</label>
            <div class="col-sm-2">
                <select name="status" id="inputRole3" class="form-control">
                    <option value="draft" <?= isset($status) && $status == 'draft' ? 'selected' : ''; ?>>Draft</option>
                    <option value="published" <?= isset($status) && $status == 'published' ? 'selected' : ''; ?>>Published</option>
                    <option value="archived" <?= isset($status) && $status == 'archived' ? 'selected' : ''; ?>>Archived</option>

                </select>

            </div>
        </div>


        <div class="checkbox">
             
            <label>
                <input type="checkbox">Allow comments
            </label>
        </div>

        <br>
        <button type="submit" class="btn btn-default">Save</button>

    </div>






</from>
