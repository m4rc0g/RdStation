# RdStation
Plugin to connect RdStation to WordPress based on <a href="https://github.com/ResultadosDigitais/rdocs/blob/master/integration_wp_cf7_3_9%2B.md">Resultados Digitais RdDocs.</a>

This is a simple plugin to connect your RdStation to your WordPress without changing your functions.php.
If you have changed before your functions.php it won't work properly. 

<h3>How to install</h3>
Just download the <a href="http://www.pixelcake.com.br/rdstation.zip"> RdStation.zip here.</a><br>
Open your WordPress admin area.<br>
Go to Plugins > Add New > Upload Plugin<br>
Find your zip file and upload it.<br>
Activate your plugin.<br>

Then go to Settings > RdStation<br>
Just fill with your token.

Now you have to install Contact Form 7 plugin and set the fields to work properly with your RdStation.<br>

<h3>Contact form 7 example</h3>

<pre>
<p>Your name (required)<br />
    [text* your-name] </p>

<p>Your e-mail (required)<br />
    [email* email] </p>

<p>Subject<br />
    [text your-subject] </p>

<p>Message<br />
    [textarea your-message] </p>

<p>[submit "Send"]</p>

<div style="display:none;">
[text identificador "YOUR IDENTIFIER"]
[text c_utmz id:cookieutmz ""]
</div>
<script type="text/javascript">
function read_cookie(a){var b=a+"=";var c=document.cookie.split(";");for(var d=0;d<c.length;d++){var e=c[d];while(e.charAt(0)==" ")e=e.substring(1,e.length);if(e.indexOf(b)==0){return e.substring(b.length,e.length)}}return null}try{document.getElementById("cookieutmz").value=read_cookie("__utmz")}catch(err){}
</script>
</pre>
You can find more information <a href="https://github.com/ResultadosDigitais/rdocs">here</a>

