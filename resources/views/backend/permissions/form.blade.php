{!! form_start($form) !!}
<div class="@boxWrapper box-primary">
    <div class="@boxHeader with-border">
        <h3 class="box-title">{{ trans('motor-backend::backend/global.base_info') }}</h3>
    </div>
    <div class="@boxBody">
        {!! form_row($form->permission_group_id) !!}
        {!! form_row($form->name) !!}
        {!! form_row($form->guard_name) !!}
    </div>
    <!-- /.box-body -->

    <div class="@boxFooter">
        {!! form_row($form->submit) !!}
    </div>
</div>
{!! form_end($form) !!}
