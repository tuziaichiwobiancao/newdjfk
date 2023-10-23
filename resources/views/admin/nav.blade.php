<ul class="nav navbar-nav">
    <li class="dropdown dropdown-language nav-item">
        <a class="dropdown-toggle nav-link" href="#" id="dropdown-flag" data-toggle="dropdown">
            <i class="flag-icon flag-icon-us"></i>
            <span class="selected-language">
                @switch(config('app.locale'))
                    @case('zh_CN')
                        简体中文
                        @break
                    @case('en')
                        English
                        @break

                @endswitch
            </span>
        </a>
        <ul class="dropdown-menu" aria-labelledby="dropdown-flag">
            <li class="dropdown-item" href="#" data-language="zh_CN">
                <a><i class="flag-icon flag-icon-fr"></i> 简体中文</a>
            </li>
            <li class="dropdown-item" href="#" data-language="en">
                <a><i class="flag-icon flag-icon-us"></i> English</a>
            </li>

        </ul>
    </li>
</ul>
<input type="hidden" name="token" id="token" value="{{ csrf_token() }}">
<script>
    $('.dropdown-item').on('click', function() {
        let lang = $(this).attr('data-language')
        let token = $("#token").val();
        $.ajax({
            url: '{{ url('admin/setLang') }}',
            type: 'post',
            data: {
                'lang': lang,
                '_token': token
            },
            success: function(data) {
                if (data.code != 0) {
                    alert(data.msg)
                    return false;
                } else {
                    window.location.reload();
                }
            }
        })
    })

</script>
