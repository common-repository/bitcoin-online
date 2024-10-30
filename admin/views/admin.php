<?php
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package   Bitcoin_Online
 * @author    PaR <pavel.rechberg@gmail.cz>
 * @license   GPL-2.0+
 * @link      
 * @copyright 2014 PaR
 */
?>
<style>
.widefat td {vertical-align: middle;}
</style>
<div class="wrap">

	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
  	<div id="poststuff">
        <div class="post-body-content">          
            <div id="post-body" class="metabox-holder columns-2" style="width: 60%;">
                <div id="post-body-content">
                <p>Shortcode which displays the prices of Bitcoin for  the most popular exchange websites <strong>MT.GOX</strong>, <strong>BitStamp.net</strong>, <strong>BTC-E.com</strong>
                </p>
                
                <h3>If you like this plugin please donate BTC: <a href="bitcoin:13mgLyY5nxzZmkBUVF2nQs88cGPGrkmB2m">13mgLyY5nxzZmkBUVF2nQs88cGPGrkmB2m</a></h3>
                <h2>MT.GOX shortcodes</h2>
                    <table class="widefat">
                    <thead>
                    <tr><th>Shortcode</th><th>Display</th><th></th></tr>
                    </thead>
                        <tr>
                         <td>[btc_online]</td>
                         <td><h2><span class="btc-online-value" data-type="last" data-value="display_short"></span></h2></td>
                         <td>last ticker value short format</td>
                        </tr>    
                        <tr>
                         <td>[btc_online data_type="avg" data_value="value"]</td>
                         <td><h2><span class="btc-online-value" data-type="avg" data-value="value"></span></h2></td>
                         <td>last ticker average value</td>
                        </tr>
                        <tr>
                         <td>[btc_online data_type="high" data_value="display"]</td>
                         <td><h2><span class="btc-online-value" data-type="high" data-value="display"></span></h2></td>
                         <td>last ticker high value long format</td>
                        </tr>
                        <tr>
                         <td>[btc_online data_type="low" data_value="display_short"]</td>
                         <td><h2><span class="btc-online-value" data-type="low" data-value="display_short"></span></h2></td>
                         <td>last ticker low value short format</td>
                        </tr>    
                        <tr>
                         <td>[btc_online data_type="buy" data_value="value_int"]</td>
                         <td><h2><span class="btc-online-value" data-type="buy" data-value="value_int"></span></h2></td>
                         <td>last ticker buy value integer format</td>
                        </tr>   
                        <tr>
                         <td>[btc_online data_type="sell" data_value="display"]</td>
                         <td><h2><span class="btc-online-value" data-type="sell" data-value="display"></span></h2></td>
                         <td>last ticker sell value long format</td>
                        </tr>   
                        <tr>
                         <td>[btc_online data_type="sell" data_value="currency"]</td>
                         <td><h2><span class="btc-online-value" data-type="sell" data-value="currency"></span></h2></td>
                         <td>currency</td>
                        </tr>                                                                                              
                    </table>
                    <h3>data_type can be: last, avg, high, low, buy, sell</h3>
                    <h3>data_value can be: value, value_int, display, display_short, currency</h3>

                <h2>BitStamp and BTC-E shortcodes</h2>
                    <table class="widefat">
                    <thead>
                    <tr><th>Shortcode</th><th>Display</th><th></th></tr>
                    </thead>
                        <tr>
                         <td>[btc_online_ex data_exchange=bitstamp]</td>
                         <td><h2>$ <span class="btc-online-value_ex" data-exchange="bitstamp">loading...</span></h2></td>
                         <td>last ticker value BitStamp exchange</td>
                        </tr>    
                        <tr>
                         <td>[btc_online_ex data_exchange=btce]</td>
                         <td><h2>$ <span class="btc-online-value_ex" data-exchange="btce">loading...</span></h2></td>
                         <td>last ticker value BTC-E exchange</td>
                        </tr>
 
                    </table>


                </div>
              	<div id="postbox-container-1" class="postbox-container">
						<a href="https://cex.io/r/0/pavre/0/" title="CEX.io - Bitcoin Commodity Exchange" target="_blank"><img src="http://cex.io/img/b/250x250.jpg" width="250" height="250" border="0" alt="CEX.io"></a>
				</div>
            </div>
       </div> 
    </div>
</div><!-- .wrap -->