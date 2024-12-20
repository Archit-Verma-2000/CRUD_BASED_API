<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Form</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
    <style>
        .vh-100 {
            height: 100vh;
        }
    </style>
</head>
<body>
    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="col-md-6 col-sm-8 col-10 mx-auto">
            <div class="card shadow-lg p-4">
                <h3 class="text-center mb-4">Register Form</h3>
                <form id="Login-Form">
                    <!-- Name field -->
                    <div class="form-group">
                        <label for="inputName">Name</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="inputName" 
                            placeholder="Enter your name" name="name">
                    </div>
                    <!-- Email Field -->
                    <div class="form-group">
                        <label for="inputEmail">Email address</label>
                        <input 
                            type="email" 
                            class="form-control" 
                            id="inputEmail" 
                            aria-describedby="emailHelp" 
                            placeholder="Enter your email" name="email">
                        <small id="emailHelp" class="form-text text-muted">
                            We'll never share your email with anyone else.
                        </small>
                    </div>
                    <!-- Date Field -->
                    <div class="form-group">
                        <label for="inputDate">Date of Birth</label>
                        <input 
                            type="date" 
                            class="form-control" 
                            id="inputDate" name="dob">
                    </div>
                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary btn-block" id="Submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <div class="container vh-100 ">
    <table id="records" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th class="bg-primary text-white border border-white">id</th>
                <th class="bg-primary text-white border border-white">name</th>
                <th class="bg-primary text-white border border-white">email</th>
                <th class="bg-primary text-white border border-white">d.o.b</th>
                <th class="bg-primary text-white border border-white">createdAt</th>
                <th class="bg-primary text-white border border-white">modifiedAt</th>
                <th class="bg-primary text-white border border-white">edit</th>
                <th class="bg-primary text-white border border-white">delete</th>
            </tr>
        </thead>
        </tfoot>
    </table>
    </div>
<div class="modal fade" id="Edit" tabindex="-1" aria-labelledby="EditModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form id="Edit-form">
                    <!-- Name field -->
                    <div class="form-group">
                        <label for="inputName" >Name</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="Editname"
                            placeholder="Enter your name" name="name">
                    </div>
                    <!-- Email Field -->
                    <div class="form-group">
                        <label for="inputEmail" >Email address</label>
                        <input 
                            type="email" 
                            class="form-control" 
                            id="Editemail"
                            aria-describedby="emailHelp" 
                            placeholder="Enter your email" name="email">
                    </div>
                    <!-- Date Field -->
                    <div class="form-group">
                        <label for="inputDate" >Date of Birth</label>
                        <input 
                            type="date" 
                            class="form-control" 
                            id="Editdob" name="dob">
                    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="save">Save changes</button>
      </div>
    </div>
  </div>
</div>
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/2.1.8/pagination/simple_incremental_bootstrap.js"></script>
    <!-- DataTables CSS -->
    <!-- DataTables Bootstrap JS -->
    
</body>
<script>
        var table =new DataTable('#records',{
             "destroy": true,
        });
        const formData=document.getElementById("Login-Form");
        const Submit=document.getElementById("Submit");
        
        function customFetch(e){
            Submit.innerHTML="Please wait";
            Submit.disabled=true;
          
            return new Promise((resolve,reject)=>{
                console.log("inside fetch");
                setTimeout(()=>{
                    var data=new FormData(formData);
                    const value = Object.fromEntries(data.entries());  
                    // console.log(JSON.stringify(value));    
                    fetch("action.php",{
                        method:"post",
                        body:JSON.stringify(value),
                        headers: {
                            "Content-type":"application/json",
                        }
                    }).then((response)=>response.json()).then((data)=>{
                            resolve(data);
                        });
                },2000);
            })     
        }
        async function asynccall(e){
            try{
                let id=1;
                await customFetch(e); 
                getFetchCall(); 
            }
            catch(e)
            {
                console.error("error occured:",e);
            }
            finally
            {
                Submit.disabled=false;
                Submit.innerHTML="Submit";
            }
                
        }
        document.addEventListener("DOMContentLoaded",(event)=>{
            getFetchCall();
            console.log("document Loaded");     
            Submit.addEventListener("click",asynccall)
        })
        function getFetchCall()
        {
            fetch("action.php",{
                        method:"get",
                        headers: {
                            "Content-type":"application/json",
                        }
                    }).then((response)=>response.json()).then((data)=>{
                            // console.log(data);
                            table.clear();
                            id=1;
                            data.forEach(function(item){
                                table.row.add(
                                    [
                                        id,
                                        item.name,
                                        item.email,
                                        item["d.o.b"],
                                        item.created_at,
                                        item.updated_at,
                                        "<button type='button' class='btn btn-success text-white'  data-bs-toggle='modal' data-bs-target='#Edit' onclick='Edit(\""+item.name+"\",\""+item.email+"\",\""+item["d.o.b"]+"\",\""+item.id+"\")'>Edit</button>",
                                        "<button  type='button' class='btn btn-danger text-white'   onclick='Delete(\""+item.id+"\")'>Delete</button>",
                                    ]
                                ).draw();
                                id++
                            });
                })
        }
        function Edit(name,email,dob,id){
           document.getElementById("Editname").value=name;
           document.getElementById("Editemail").value=email;
           document.getElementById("Editdob").value=dob;
           document.getElementById("save").addEventListener("click",()=>{
                Editform=document.getElementById("Edit-form");
                data=new FormData(Editform);
                data.append("id",id);
                const value=Object.fromEntries(data.entries());
                fetch('action.php',{
                    method:"PATCH",
                    body:JSON.stringify(value),
                    headers: {
                            "Content-type":"application/json",
                        }
                }).then((response)=>(response).text()).then((data)=>{
                    console.log(data);
                    getFetchCall()
                }) 
           });
        }
        function Delete(id){
                payload={"id":id};
                fetch('action.php',{
                    method:"DELETE",
                    body:JSON.stringify(payload),
                    headers: {
                            "Content-type":"application/json",
                        }
                }).then((response)=>(response).text()).then((data)=>{
                    console.log(data);
                    document.getElementById('save').addEventListener('click', function() {
                    const modalElement = document.getElementById('Edit');
                    const modalInstance = bootstrap.Modal.getInstance(modalElement);
                    modalInstance.hide();
                });
                    getFetchCall()
                }) 
        }
</script>
</html>
