# RdStation
Plugin to connect RdStation to WordPress based on <a href="https://github.com/ResultadosDigitais/rdocs/blob/master/integration_wp_cf7_3_9%2B.md">Resultados Digitais RdDocs.</a>

<strong>Tested on WordPress 4.2.1</strong>

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

<pre><code>&lt;p&gt;Your name (required)&lt;br /&gt;
    [text* your-name] &lt;/p&gt;

&lt;p&gt;Your e-mail (required)&lt;br /&gt;
    [email* email] &lt;/p&gt;

&lt;p&gt;Subject&lt;br /&gt;
    [text your-subject] &lt;/p&gt;

&lt;p&gt;Message&lt;br /&gt;
    [textarea your-message] &lt;/p&gt;

&lt;p&gt;[submit "Send"]&lt;/p&gt;

&lt;div style="display:none;"&gt;
[text identificador "YOUR IDENTIFIER"]
[text c_utmz id:cookieutmz ""]
&lt;/div&gt;
&lt;script type="text/javascript"&gt;
function read_cookie(a){var b=a+"=";var c=document.cookie.split(";");for(var d=0;d&lt;c.length;d++){var e=c[d];while(e.charAt(0)==" ")e=e.substring(1,e.length);if(e.indexOf(b)==0){return e.substring(b.length,e.length)}}return null}try{document.getElementById("cookieutmz").value=read_cookie("__utmz")}catch(err){}
&lt;/script&gt;
</code></pre>

You can find more information <a href="https://github.com/ResultadosDigitais/rdocs">here</a>

