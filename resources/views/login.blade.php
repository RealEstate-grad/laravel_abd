<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="{{route('loginuser')}}" method="POST" >
<div id = "legend">
<lengend class = " "> login </lengend >
 

</br></br> <div class = "control_group " >
    <label class = "control_label" for ="name"><b><i> user name </label >
  <div class = "controls " >
 <input type="text" id ="name" name = "name" class input-xlary >
</div>
</div>


<div class = "control_group " >
 <label class = "control_label" for ="email"> email </label >
  <div class = "controls " >
 <input type="email" id ="email" name = "email" class input-xlary >
</div>
</div>



<div class = "control_group " >
 <label class = "control_label" for ="password"> password </label >
  <div class = "controls " >
 <input type="text" id ="password" name = "password " class input-xlary >
</div>
</div>

<div class = "control_group " > 
  <label class = "control_label" for ="submite"> submite </label >
  <div class = "controls " >
  <input type="submit"  value ="submite form " class input-xlary >

</div>
</div>
</body>
</html>