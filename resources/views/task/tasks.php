<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <script type="text/javascript" src='https://unpkg.com/vue'></script>
  </head>
  <body>
    <div class="app">
        <login-form></login-form>
    </div>
    <script>
    Vue.component ('login-form', {
      data: function() {
        return {
          auth: [
            login : '',
            password : ''
          ]
        }
      },

      actions: {
        login () {
          axios.post('calendar/login', {
            login: this.login,
            password: this.password,
          })
        }
      },

      template: '<div><form action="" method="get"><input name="login" type="text" value={{ auth.login }}/><input name="password" type="text" value={{ auth.password }}/></form></div>'
    });

    new Vue({
      el: '#app',
      data {

      }
    })
    </script>
  </body>
</html>
