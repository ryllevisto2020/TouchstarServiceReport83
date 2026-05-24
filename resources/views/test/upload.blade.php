<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>Document</title>
</head>
<body>
    <form id="formUpload" enctype="multipart/form-data">
        <input type="file" id="fileUpload" name="fileUpload"/>
        <input type="submit" name="upload"/>
    </form>
</body>
</html>
<script>
    $(document).ready(function(){
        $("#formUpload").submit(function(e){
            e.preventDefault();
            let form = new FormData();
            form.append("test",$("#fileUpload")[0].files[0])
            $.ajax({
                type: "POST",
                url: "/service/add",
                data: form,
                contentType: false,
                processData: false,
                success: function (response) {

                }
            });
        })

    })
</script>
