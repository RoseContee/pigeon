@if(session('info_message'))
    <div class="alert alert-info alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
        <?php echo session('info_message') ?>
    </div>
@endif
@if(session('error_message'))
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
        <?php echo session('error_message') ?>
    </div>
@endif