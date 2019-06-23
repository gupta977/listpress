<h1>ListPress Tutorials</h1>
<b>Contact navneet@odude.com for more help</b>
<hr>
As soon as ListPress is installed, you need to check ListPress Settings and save the value as you prefer. You cannot move further without completing this step.<br>

<br>Just copy paste this shortcode <b>[listpress]</b> where ever you want to display contact button.<br><br>
If you like to display button at <b>UPG or WooCommerce plugin</b> then no need to keep [listpress] shortcode. Simply go to plugins tab and select the values you want to keep.<br><br>

[listpress] shortcode will use values saved at ListPress settings.<br>
But you can also change this value as required. It means one button can act as 'Feedback 
Form' and other as 'Report Spam' button.
<hr><br>
<b>Available Parameters</b>
<ul>
<li><b>layout</b>: You can make your own or select from available list. <br>Eg.[listpress layout="layout_name"]</li>
<li><b>label</b>: Changes label of the contact button.</li>
<li><b>title</b>: Changes title of the popup form.</li>
<li><b>info</b>: Small description of the form below title.</li>
<li><b>plugin</b>: Special values specific to plugin. For eg. if you are placing button at UPG plugin then the shortcode will be [listpress plugin="upg"].</li>
<li><b>class</b>: The button layout can be changed as to your theme layout. Just find out the css class name that works best with label tag and keep that value. <br>Eg. [listpress  class="pure-button"] </li>
<li><b>to</b>:You can set recipients email address at ListPress settings. <br>But you can add more email address according to form type. [listpress to="email1@gmail.com"]. This way the single form will send email to both the email address.</li>
</ul>

<hr><br>
<b>Custom Form Fields</b>
<br>
Go to layout editor and choose the layout you want to add fields.<br>
Insert HTML input fields as to you requirement. ListPress will automatically get those fields. <br>
There are some restrictions which are mentioned at the right side of editor.