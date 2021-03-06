<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title>Wireless DataBase  {$wifidb_version_label}  --&gt; {$wifidb_page_label}</title>
        <meta name="description" content="A Wireless Database based off of scans from Vistumbler." />
        <meta name="keywords" content="WiFiDB, linux, windows, vistumbler, Wireless, database, db, php, mysql" />
        {$redirect_func}
    </head>
    <body style="background-color: #145285" {$redirect_html}>
        <link rel="stylesheet" href="{$wifidb_host_url}themes/vistumbler/styles.css" />
        
        <table style="width: 90%; " class="no_border" align="center"><tr><td><p class='annunc_text'>Well... here we go again.... -phil</p></td></tr></table>

        <table style="width: 90%; " class="no_border" align="center">
            <tr>
                <td>
                    <table>
                        <tr>
                            <td style="width: 228px">
                                <a href="http://www.randomintervals.com">
                                <img alt="Random Intervals Logo" src="{$wifidb_host_url}themes/vistumbler/img/logo.png" class="no_border" /></a>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table style="width: 90%" align="center">
            <tr>
                <td style="width: 165px; height: 114px" valign="top">
                    <table style="width: 100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="width: 10px; height: 20px" class="cell_top_left">
                                <img alt="" src="{$wifidb_host_url}themes/vistumbler/img/1x1_transparent.gif" width="10" height="1" />
                            </td>
                            <td class="cell_top_mid" style="height: 20px">
                                <img alt="" src="{$wifidb_host_url}themes/vistumbler/img/1x1_transparent.gif" width="185" height="1" />
                            </td>
                            <td style="width: 10px" class="cell_top_right">
                                <img alt="" src="{$wifidb_host_url}themes/vistumbler/img/1x1_transparent.gif" width="10" height="1" />
                            </td>
                        </tr>
                        <tr width="185px">
                            <td class="cell_side_left">&nbsp;</td>
                            <td class="cell_color">
                                <div class="inside_dark_header">WiFiDB Links</div>
                                <div class="inside_text_bold"><strong>
                                    <a href="{$wifidb_host_url}">Main Page</a></strong></div>
                                <div class="inside_text_bold"><strong>
                                    <a href="{$wifidb_host_url}all.php?sort=SSID&ord=ASC&from=0&to=100">View All APs</a></strong></div>
                                <div class="inside_text_bold"><strong>
                                    <a href="{$wifidb_host_url}import/">Import</a></strong></div>
                                <div class="inside_text_bold"><strong>
                                    <a href="{$wifidb_host_url}opt/scheduling.php">Files Waiting for Import</a></strong></div>
                                <div class="inside_text_bold"><strong>
                                    <a href="{$wifidb_host_url}opt/scheduling.php?func=done">Files Already Imported</a></strong></div>
                                <div class="inside_text_bold"><strong>
                                    <a href="{$wifidb_host_url}opt/scheduling.php?func=daemon_kml">Daemon Generated kml</a></strong></div>
                                <div class="inside_text_bold"><strong>
                                    <a href="{$wifidb_host_url}console/">Daemon Console</a></strong></div>
                                <div class="inside_text_bold"><strong>
                                    <a href="{$wifidb_host_url}opt/export.php?func=index">Export</a></strong></div>
                                <div class="inside_text_bold"><strong>
                                    <a href="{$wifidb_host_url}opt/search.php">Search</a></strong></div>
                                <div class="inside_text_bold"><strong>
                                    <a href="{$wifidb_host_url}themes/">Themes</a></strong></div>
                                <div class="inside_text_bold"><strong>
                                    <a href="{$wifidb_host_url}opt/userstats.php?func=allusers">View All Users</a></strong></div>
                                <div class="inside_text_bold"><strong>
                                    <a class="links" href="http://forum.techidiots.net/forum/viewforum.php?f=47">Help / Support</a></strong></div>
                                <div class="inside_text_bold"><strong>
                                    <a href="{$wifidb_host_url}ver.php">WiFiDB Version</a></strong></div>
                                <br>
                                <div class="inside_dark_header">[Mysticache]</div>
                                <div class="inside_text_bold"><a class="links" href="{$wifidb_host_url}caches.php">View shared Caches</a></div>
                                <!--   User Mysicache Link   -->
                                <div class="inside_text_bold">
                                    <a class="links" href="{$wifidb_host_url}cp/?func=boeyes&boeye_func=list_all&sort=id&ord=ASC&from=0&to=100">List All My Caches</a>
                                </div>
                                <!--=========================-->
                            </td>
                            <td class="cell_side_right">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="cell_bot_left">&nbsp;</td>
                            <td class="cell_bot_mid">&nbsp;</td>
                            <td class="cell_bot_right">&nbsp;</td>
                        </tr>
                        
                        <!-- CUSTOM NAV -->
                        {include file="navigation.tpl"}
                        <!-- END CUSTOM NAV-->
                    </table>
                </td>
                    <td style="height: 114px" valign="top" class="center">
                    <table style="width: 100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="width: 10px; height: 20px" class="cell_top_left">
                                <img alt="" src="{$wifidb_host_url}themes/vistumbler/img/1x1_transparent.gif" width="10" height="1" />
                            </td>
                            <!-- ------ WiFiDB Login Bar ---- -->
                            <td class="cell_top_mid" style="height: 20px" align="left">
                                {$wifidb_login_html|default:""}
                            </td>
                            <td class="cell_top_mid" style="height: 20px" align="right">
                                <a class="links" href="{$wifidb_host_url}login.php?{$wifidb_current_uri}">{$wifidb_login_label|default:'login'}</a>
                            </td>
                            <!-- ---------------------------- -->
                            <td style="width: 10px" class="cell_top_right">
                                <img alt="" src="{$wifidb_host_url}themes/vistumbler/img/1x1_transparent.gif" width="10" height="1" />
                            </td>
                        </tr>
                        <tr>
                            <td class="cell_side_left">&nbsp;</td>
                            <td class="cell_color_centered" align="center" colspan="2">
                                <div align="center">