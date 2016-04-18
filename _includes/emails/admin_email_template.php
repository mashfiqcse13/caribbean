<?php

function AdminemailTemplate($fieldsArray = '') {
    $admin_message = "";
    $TotalFieldsHTML = '';
    $admin_message .= '<html xmlns="http://www.w3.org/1999/xhtml">
    		            <head>
    		            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    		            </head>
    		            <body>
    		            ';

    if (count($fieldsArray) > 0) {
        foreach ($fieldsArray as $key => $value) {
            $TotalFieldsHTML .=
                    '<tr>
                    <td style="padding:5px; font-family:arial, sans-serif; font-size:14px; background:#f0f0f0; border: 2px #fff solid; font-weight: bold; color: #666;">' . $key . '</td>
                    <td style="padding:5px; font-family:arial, sans-serif; font-size:14px; background:#f0f0f0; border: 2px #fff solid; font-weight: bold; color: #666;">' . $value . '</td>
                </tr>';
        }
    } else {
        $TotalFieldsHTML .=
                '<tr>
                <td style="padding:5px; font-family:arial, sans-serif; font-size:14px; background:#f0f0f0; border: 2px #fff solid; font-weight: bold; color: #666;">No Data:</td>
                <td style="padding:5px; font-family:arial, sans-serif; font-size:14px; background:#f0f0f0; border: 2px #fff solid; font-weight: bold; color: #666;">No Data</td>
            </tr>';
    }


    $admin_message .= '<table width="100%" align="center">
    		    <tr>
    		        <td align="center" width="100%">
    		            <table border="0" cellspacing="0" cellpadding="0" style="width:600px; margin:0 auto; font-size:12px; font-family:arial, sans-serif;">
    		                <tr style="background:#FFFFFF; text-align: center;">
    		                    <td colspan="2">
    		                        <img src="' . SITE_URL . '/_images/logo.png" width="289" height="57" alt="Caribbean Circele Start">
    		                    </td>
    		                </tr>
    		                <tr>
    		                    <td>&nbsp;</td>
    		                    <td>&nbsp;</td>
    		                </tr>
    		                <tr style="background:#6fb256; color: #FFF; font-size: 16px;">
    		                    <td colspan="2" style="width: 100%; padding: 10px; font-family:arial, sans-serif; font-weight:bold;">New Contact Form Request</td>
    		                </tr>
    		                <tr>
    		                    <td>&nbsp;</td>
    		                    <td>&nbsp;</td>
    		                </tr>
    		                <tr>
    		                    <td colspan="2">
    		                        <table width="600" border="0" cellspacing="0" cellpadding="0" style=" border:1px solid #e8e6e6;">
    		                        ';


    $admin_message .= $TotalFieldsHTML;
    $admin_message .= '         </table>
    		                    </td>
    		                </tr>
    		                <tr>
    		                    <td>&nbsp;</td>
    		                    <td>&nbsp;</td>
    		                </tr>
    		                <tr style=" background:#6fb256; color: #FFF; font-family:arial, sans-serif; font-size:12px; text-align: center;">
    		                    <td colspan="2" style="width: 100%; padding:10px 0;">
    		                        Copyright &copy;     2015 Caribbean Circle Stars. All rights Reserved.
    		                    </td>
    		                </tr>
    		            </table>
    		        </td>
    		    </tr>
    		</table>
    		';

    $admin_message .= "</body>\n";
    $admin_message .= "</html>\n";
    /** Admin Email html end */
    return $admin_message;
}
