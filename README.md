<h1>Playermapper</h1>
<H2>Visual WoW Map for Trinitycore - [IN DEVELOPMENT]</H2>
High detailed view of players live location in the WoW world that can be integrated to any web server site with a Google map style of functionality.
<br>
<br>
<table><td>Please note: This is a current work in progress. If you want to contribute to the project please contact me via these options</table>
<ul>
<li>IRC [~cellyson@Rizon-8476EC9E.hfc.comcastbusiness.net]</li>
<li>Discord chat: @CDawg [#8963]</li>
<li><a href="https://community.trinitycore.org/messenger/compose/?to=11159">Trinitycore message</a></li>
</ul>
<br>
<table><td>Please do NOT fill out a github issue saying that a feature is broken without checking this list first!</table>
<b>Maps:</b>
<br>
☐ Azeroth
<br>
☑ Outland
<br>
☐ Northrend
<br>
☐ Cataclysm: new Azeroth/Deepholm
<br>
☐ MoP: Pandaria
<br>
☐ Wod: Draenor
<br>
☐ Legion: Broken Isles
<br>
<br>
<b>Features:</b>
<br>
☑ Map zoom in/out
<br>
☑ Map dragging (Google Map style navigation)
<br>
☑ Minimap
<br>
☑ Navigation for older browsers
<br>
☑ Multi Realm support
<br>
☑ Player Search
<br>
☐ LIVE player positioning
<br>
☐ Zone search
<br>
☐ Zone boundaries
<br>
☐ Zone detail identification
<br>
☐ add GM visibility [enable/disable] feature
<br>
☐ Instance Identification
<br>
☐ Player group feature (who is grouped in world)
<br>
<br>
<b>WoW Platform:</b>
<br>
☑ TrinityCore
<br>
☐ Mangos
<br>
<br>
<b>Misc:</b>
<br>
☐
<br>

<h3>Installation & Requirements - [Difficulty level : Medium to Advanced]</h3>
<table><td>Please note: If you are inexperienced on running a web or database server. I will NOT help you set up/troubleshoot server issues.</table>
<h3>Linux requirements</h3>
<ul>
<li>Apache 2.0+ or Nginx 1.12+</li>
<ul><li>Apache Rewrite Module (Optional)</li></ul>
<li>PhP 5.3.5+</li>
<li>php-mysql 5.3+</li>
<li>MySQL 5.5+/MariaDB</li>
</ul>

<table><td>Please note: I don't use the Windows OS, so I did my best to relay what you need in order to run this on your Windows web machine. If you have never run a web machine on Windows, I would recommend starting with Apache for Windows. I will NOT help you set up your web server.</table>
<h3>Windows requirements</h3>
Windows 7+
<br>https://httpd.apache.org/download.cgi
<br>http://windows.php.net/
<br>MySQL 5.5+ or MariaDB 10.2+
<br>
<br>
<h3>Setup Instructions</h3>
git clone to your web directory and change the config options under config/config.php
...
