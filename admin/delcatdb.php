<?php
ob_start();
require_once('admin_include_fns.php');

$conn = db_connect();
$companys = array();
$error = true;

$rid = $_SESSION['customer']['rid'];
if (isset($_POST['cats']) && count($_POST['cats']) > 0) {
    $cats = $_POST['cats'];
    $parameter = implode(',', $cats);

    
    // 这里作安全验证，只能查出和rid 相关分类ID
    $query = "SELECT catalogID FROM catalog  WHERE rid = $rid AND (catalogID in ($parameter) ) ";

    $result = $conn->query($query);
    if ($result->num_rows < 0) {
        echo '删除失败，系统错误!';
    } else if ($result->num_rows > 0) {
        $parameter = '';
        $catsID = db_result_to_array($result);
        for($i = 0; $i < count($catsID); $i++){
            if(!dbselect('goods','catalogId',$catsID[$i]['catalogID'])){
                // 待测试
                $parameter .= $catsID[$i]['catalogID'] . ",";
            }
        }
        if(empty($parameter)){
            echo '请先删除该分类下的商品'; 
            $url = 'delcatalog.php';
            header('Refresh: 1; url=' . $url);
            exit;
        }
        $parameter = substr($parameter,0,-1);


        $query = "SELECT image FROM catalog WHERE catalogID in (" . $parameter . ")";
        $result = $conn->query($query);

        /*  例行检测 */
        if(!$result){
            echo '删除失败，系统错误!';
            $url = 'delcatalog.php';
            header('Refresh: 1; url=' . $url);
        }
        /* */

        $tempimgs = array();
        if($result->num_rows > 0){
            $result = db_result_to_array($result);
            for($i = 0; $i < count($result); $i++){
                $tempimgs[] = $result[$i]['image']; 
            }

            $conn->autocommit(FALSE);
            $query = "DELETE FROM catalog WHERE catalogID in (" . $parameter . ")";
            $conn->query($query);
            if(!($conn->affected_rows > 0)){
                echo '删除失败，系统错误!';
            }

            if(!empty($tempimgs)){
                foreach ($tempimgs as $value) {
                    if (@file_exists($imgcat.$value)){
                        if(!unlink($imgcat.$value))
                            $error = false;
                    }
                }
                if($error){
                    $conn->commit();
                    $conn->autocommit(TRUE);
                    echo "删除成功";
                }else{
                    echo "删除失败，系统错误";
                }
            }
            
        }
    }
    $url = 'delcatalog.php';
    header('Refresh: 1; url=' . $url);
    exit;

}
echo "请选择要删除的分类";
$url = 'delcatalog.php';
header('Refresh: 1; url=' . $url);
exit;

ob_end_flush();
?>