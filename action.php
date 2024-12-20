<?php
    $server="Localhost";
    $user="root";
    $password="";
    $database="db_register";
    $conn=mysqli_connect($server,$user,$password,$database);
    if(!$conn)
    {
        die("Connection not established");
    }
?>
<?php
    function showdata($conn){
        $sql="SELECT * FROM users ORDER BY id DESC LIMIT 1";
        $stmt=$conn->prepare($sql);
        $stmt->execute();
        $res=$stmt->get_result();
        $rows=$res->fetch_all(MYSQLI_ASSOC);
        return $rows;
    }
    function showdataAll($conn){
        $sql="SELECT * FROM users";
        $stmt=$conn->prepare($sql);
        $stmt->execute();
        $res=$stmt->get_result();
        $rows=$res->fetch_all(MYSQLI_ASSOC);
        return $rows;
    }
    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
       $rawData=file_get_contents("php://input");
       $data=json_decode($rawData,true);
       $name=$data["name"];
       $email=$data["email"];
       $dob=$data["dob"];
       $sql="INSERT INTO users(`name`,`email`,`d.o.b`) VALUES(?,?,?)";
       $stmt=$conn->prepare($sql);
       $stmt->bind_param("sss",$name,$email,$dob);
       $stmt->execute();
       $res[]=[
            "status"=>"user added",
       ];
       echo json_encode($res);
    }
    else if($_SERVER["REQUEST_METHOD"]=="GET")
    {
        $res=showdataAll($conn);
        echo json_encode($res);
    }
    else if($_SERVER["REQUEST_METHOD"]=="PATCH")
    {
        $rawData=file_get_contents("php://input");
        $data=json_decode($rawData,true);
        $name=$data["name"];
        $email=$data["email"];
        $dob=$data["dob"];
        $id=$data["id"];
        $sql="UPDATE users SET `name`=?,`email`=?,`d.o.b`=?,`updated_at`=CURRENT_TIMESTAMP() WHERE id=?";
        $stmt=$conn->prepare($sql);
        $stmt->bind_param("sssi",$name,$email,$dob,$id);
        $stmt->execute();
        echo json_encode(
            [
                "status"=>"User updated",
            ]
            );
    }
    else if($_SERVER["REQUEST_METHOD"]=="DELETE")
    {
        $rawData=file_get_contents("php://input");
        $data=json_decode($rawData,true);
        $id=$data["id"];
        $sql="DELETE FROM users where id=?";
        $stmt=$conn->prepare($sql);
        $stmt->bind_param("i",$id);
        $stmt->execute();
        echo json_encode(
            [
                "status"=>"User Deleted",
            ]
            );
    }
?>