
<?php

echo '
        <h4>图书</h4>
        
                <input type="hidden" name="add_type" value="book"/><br />
                <table>
                    <tr>
                        <td>商品编号：</td>
                        <td><input type="text" name="goods_id" value="" /><br /></td>
                    </tr>
                    <tr>
                        <td>书名：</td>
                        <td><input type="text" name="name" value="" /><br /></td>
                    </tr>
                    <tr>
                        <td>作者：</td>
                        <td><input type="text" name="author" value="" /><br /></td>
                    </tr>
                    <tr>
                        <td>价格：</td>
                        <td><input type="text" name="price" value=""/><br /></td>
                    </tr>
                    <tr>
                        <td>出版社：</td>
                        <td><input type="text" name="pub_house" value=""/><br /></td>
                    </tr>
                    <tr>
                        <td>出版时间：</td>
                        <td><input type="text" name="pub_time" value=""/><br /></td>
                    </tr>
                    <tr>
                        <td>类型：</td>
                        <td>
                        历史<input type="radio" name="type" value="history"/>
                        计算机<input type="radio" name="type" value="computer"/>
                        </td>
                    </tr>
                    <tr>
                        <td>上架</td>
                        <td><input type="submit" name="submit" value="上架"/></td>
                    </tr>
                </table>
        
';
?>
