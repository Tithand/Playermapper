<h1>Playermapper</h1>
<H2>Visual WoW Map for Trinitycore - [IN DEVELOPMENT]</H2>
High detailed view of players live location in the WoW world that can be integrated to any web server site with a Google map style of functionality.
<br>

> Please note: This is currently an open source work in progress. Please contribute to the project. If you would like to contribute to the project please contact me via these options or fork this repo, make your adjustment/fix and submit a PR  :-)

<ul>
<li>Contact me on Discord - https://discord.gg/6gmcyf</li>
<li><a href="https://community.trinitycore.org/messenger/compose/?to=11159">Trinitycore message</a></li>
</ul>
<br>

3.3.5a Video Demo
[![335a Demo](https://github.com/CDawg/Playermapper/blob/master/demo/335a_vid.jpg)](https://youtu.be/BMf5aOFGuiE)

> Please do NOT fill out a github issue saying that a feature is broken without checking this Tasklist! I will only help those that have cloned the repo and using the latest commit. This project is continually evolving with improvements made almost weekly. If you are not using the latest commit, you will not get help.

<h3>Compatible Browsers:</h3>
☑ Google Chrome v59.0+
<br>
☑ Microsoft Edge v25.0+
<br>
☑ Mozilla Firefox v45.0+
<br>
☑ Safari v10.1++

<h3>Completed Versions:</h3>
☑ 1.x
<br>
☑ 2.x
<br>
☑ 3.x
<br>
☑ 4.x
<br>
☑ 5.x
<br>
☑ 6.x
<br>
☐ 7.x

<h3>Completed Maps:</h3>
☑ Azeroth
<br>
☑ Outland
<br>
☑ Northrend
<br>
☑ Cataclysm: Azeroth/Deepholm
<br>
☑ Pandaria
<br>
☑ Draenor
<br>
☐ Broken Isles

<h3>Completed Features:</h3>
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
☑ Text Console
<br>
☑ Player Search
<br>
☑ LIVE player positioning (optional will need core modifcation with .patch)
<br>
☐ Zone search
<br>
☑ Zone boundaries
<br>
☑ Zone detail identification
<br>
☑ add GM visibility [enable/disable] feature
<br>
☐ Flight paths
<br>
☐ Player instance identification
<br>
☐ Player group feature (who is grouped in world)
<br>
<br>

<h2>Installation & Requirements - [Difficulty level : Medium to Advanced]</h2>

> Please note: If you are inexperienced on running a web or database server please read how to set one up, I will NOT help you set up/troubleshoot server issues.

<h3>Linux requirements</h3>
<ul>
<li>Apache 2.0+ or Nginx 1.12+</li>
<ul><li>Apache Rewrite Module (Optional)</li></ul>
<li>PhP 5.3.5+</li>
<li>php-mysql 5.3+</li>
<li>MySQL 5.5+/MariaDB</li>
<li>Git</li>
</ul>
<br>

> Please note: This environment was set up using Linux OS, so I did my best to relay what you need in order to run this on your Windows web machine. If you have never ran a web machine on Windows, I would recommend starting with Apache for Windows. I will NOT help you set up your web server.

<h3>Windows requirements</h3>
<ul>
<li>Windows 7+ (recommended Windows Server)</li>
<li>Apache - https://httpd.apache.org/download.cgi</li>
<li>PhP 5+ - http://windows.php.net/</li>
<li>MySQL 5.5+ or MariaDB 10.2+</li>
<li>Git Extensions</li>
</ul>
<br>

> I would NOT recommend to download as a zip, CLONE the repo from github to attach the latest commit revision. I will NOT help you if you are not using the latest commit.

<h2>Setup Instructions</h2>
<b>1.</b> git clone to your web directory (git clone https://github.com/CDawg/Playermapper.git). For Windows users, use git extensions and git clone to new directory.
<br>
<b>2.</b> Rename config.php.dist to config.php (This file is not accessible to the public)
<br>
<b>3.</b> Modify config.php with your database information within the array and provide the realm name. (follow instructions in the config file). The config file is protected and can not be accessed from the public (while php/apache is running on your machine). Do NOT skip step number 2.
<br>
<b>4.</b> (Optional) If you want to run a LIVE player location mapping, then you will need to make modifications to your core and recompile your server. "git apply" the patch file under /patch directory.

<h2>How to keep Playermapper up to date</h2>
- (Recommended) If you cloned from this repository, <i>git pull</i> to update all the necessary changes. The config.php file will not be changed.
<br>
- If you chose to fork the project and make custom modifications, you will have to choose the diffs and cherry pick to keep the project updated manually.
