    <div class="site-footer clearfix u-textAlignCenter footer-link ">
        @if(count($links)>0)
        友情链接：
        <span class="layui-breadcrumb" lay-separator="|" style="visibility: visible;">
            @foreach($links as $link)
                <a href="{{$link['link']}}"  target="_blank" >{{ $link['name'] }}</a>
            @endforeach
        </span>
        @endif
    </div>
    <footer class="footer">
        <div class="footavatar site-footer clearfix u-textAlignCenter">
            <img src="{{ asset($web_info->web_logo) }}" alt="logo" title="{{ $web_info->web_logo_description }}" class="footphoto">     
            <ul class="footinfo">
                <p class="fname"><a>{{ $web_info->web_name }}</a></p>
                <p class="finfo">{{ $web_info->web_title }}</p>
            </ul>
        </div>
        <div class="Copyright">
            <p>
                <a target="_blank" href="//shang.qq.com/wpa/qunwpa?idkey=c4f068d3baefa9f0e31f6271d9bebe70e542830dd6e713d7689fd2a084a952e7">
                    <img border="0" src="//pub.idqqimg.com/wpa/images/group.png" alt="php行业交流" title="php行业交流">
                </a>
            </p><br>
            Powered by <a href="http://www.m-finder.com" target="_blank">M-finder</a> 
        </div>
    </footer>
    
    </body>
</html>