{{HTML::style('css/index.css')}}
{{HTML::style('css/lb_signup.css')}}
{{HTML::style('css/foxy_home.css')}}
{{HTML::style('css/bootstrap_home.css')}}

{{HTML::script('js/jquery-1.11.1.min.js')}}
{{HTML::script('js/simple-expand.js')}}
{{HTML::script('js/jquery.lightbox_me.js')}}
{{HTML::script('js/bootstrap.min.js')}}


{{Form::open(array('url' => 'change_password', 'method' => 'get'))}}

 <div class="pure-control-group">
            <label for="name">Username</label>
            <input id="username_join_now" type="text" placeholder="Username" name="username">
        </div>
 <div class="pure-control-group">
            <label for="password">New Password</label>
            <input id="password" type="password" placeholder="Password" name="password">
</div>

		<div class="pure-controls">
          <input type="submit" name="Submit" class="pure-button pure-button-primary" style="margin-top:8px" value="Submit">
        </div>

{{Form::close()}}