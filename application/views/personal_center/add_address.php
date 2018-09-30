
<?php

echo '
        <div id="title"><h4>新增收货地址</h4></div>
            <form action="/gouwu/index.php/Personal_Center/Personal_info/add_address" method="post">
                <table>
                    <tr>
                        <td>收件人：</td>
                        <td><input type="text" name="contactor" value="" /><br /></td>
                    </tr>
                    <tr>
                        <td>联系电话：</td>
                        <td><input type="text" name="phone" value="" /><br /></td>
                    </tr>
                    <tr>
                        <td>收货地址：</td>
                        <td><input type="text" name="address" value="" /><br /></td>
                    </tr>
                    <tr>
                        <td>操作</td>
                        <td><input type="submit" value="保存"/></td>
                    </tr>
                </table>
            </form>
';
?>
