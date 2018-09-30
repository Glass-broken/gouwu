<?php
echo '
        <h4>电脑</h4>
        
                <input type="hidden" name="add_type" value="computer"/><br />
                <table>
                    <tr>
                        <td>商品编号：</td>
                        <td><input type="text" name="goods_id" value="" /><br /></td>
                    </tr>
                    <tr>
                        <td>品牌：</td>
                        <td><input type="text" name="brand" value="" /><br /></td>
                    </tr>
                    <tr>
                        <td>型号：</td>
                        <td><input type="text" name="model" value="" /><br /></td>
                    </tr>
                    <tr>
                        <td>屏幕尺寸：</td>
                        <td><input type="text" name="screen_size" value=""/><br /></td>
                    </tr>
                    <tr>
                        <td>处理器：</td>
                        <td><input type="text" name="cpu" value=""/><br /></td>
                    </tr>
                    <tr>
                        <td>内存容量：</td>
                        <td><input type="text" name="ram" value=""/><br /></td>
                    </tr>
                    <tr>
                        <td>硬盘容量：</td>
                        <td><input type="text" name="disk_capacity" value=""/><br /></td>
                    </tr>
                    <tr>
                        <td>显卡：</td>
                        <td><input type="text" name="gpu" value=""/><br /></td>
                    </tr>
                    <tr>
                        <td>描述：</td>
                        <td><input type="text" name="description" value=""/><br /></td>
                    </tr>
                    <tr>
                        <td>价格：</td>
                        <td><input type="text" name="price" value=""/><br /></td>
                    </tr>
                    <tr>
                        <td>上架</td>
                        <td><input type="submit" name="submit" value="上架"/></td>
                    </tr>
                </table>
               
                ';
?>