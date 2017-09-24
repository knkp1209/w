// function changeimg(id, img) {
//     document.getElementById("myImage" + id).src = img;
// }

// function sourceimg(id, img) {
//     document.getElementById("myImage" + id).src = img;
// }

function delimg(i) {
    var parent = document.getElementById('oldimgdy' + i);
    var imgchild = document.getElementById('vi' + i);
    var bnchild = document.getElementById('bn' + i);
    var valchild = document.getElementById('val' + i);
    parent.removeChild(imgchild);
    parent.removeChild(bnchild);
    parent.removeChild(valchild);
}

// function showPicture(imgFile) {
//     document.getElementById("newImage").src = window.URL.createObjectURL(imgFile.files[0]);
// }



// function addPic1() {
//     var addBtn = document.getElementById('addBtn');
//     var input = document.createElement('input');
//     input.type = 'file';
//     input.name = 'imagefile[]';
//     input.className = 'abc';
//     var picInut = document.getElementById('picInput');
//     picInut.appendChild(input);
//     if (picInut.children.length == 10) {
//         addBtn.disabled = 'disabled';
//     }
// }


function check_all(obj, cName) {
    var checkboxs = document.getElementsByName(cName);
    for (var i = 0; i < checkboxs.length; i++) { checkboxs[i].checked = obj.checked; }
}


function checkadminName() {
    var name = document.getElementsByName('adminname')[0]; //在这里我认为： name 代表的name 为 txtUser 的文本框 
    if (name.value.length == 0) {
        alert("请输入用户名");
        name.focus();
        return false;
    } else {
        return true;
    }
}


function checkpassword() {
    var name = document.getElementsByName('pass')[0]; //在这里我认为： name 代表的name 为 txtUser 的文本框 
    if (name.value.length == 0) {
        alert("请输入密码");
        name.focus();
        return false;
    } else {
        return true;
    }
}


function checkform() {
    if (checkadminName() && checkpassword())
        return true;
    else
        return false;
}



/*
function addcase() {
    var addBtn = document.getElementById('addBtn');

    var hr = document.createElement('hr');

    var img = document.createElement('input');
    var codeimg = document.createElement('input');
    var title = document.createElement('input');
    var subtitle = document.createElement('input');

    img.type = 'file';
    img.name = 'imagefile[]';
    img.className = 'forminline';

    codeimg.type = 'file';
    codeimg.name = 'codeimagefile[]';
    codeimg.className = 'forminline';

    title.type = 'text';
    title.name = 'title[]';
    title.className = 'forminline';

    subtitle.type = 'text';
    subtitle.name = 'subtitle[]';
    subtitle.className = 'forminline';

    var labelimg = document.createElement('label');
    labelimg.innerHTML = '小程序图片';

    var labelcodeimg = document.createElement('label');
    labelcodeimg.innerHTML = '小程序码图片';

    var labeltitle = document.createElement('label');
    labeltitle.innerHTML = '标题';

    var labelsubtitle = document.createElement('label');
    labelsubtitle.innerHTML = '副标题';

    var picInut = document.getElementById('picInput');
    picInut.appendChild(hr);
    picInut.appendChild(labelimg);
    picInut.appendChild(img);


    picInut.appendChild(labelcodeimg);
    picInut.appendChild(codeimg);

    picInut.appendChild(labeltitle);
    picInut.appendChild(title);

    picInut.appendChild(labelsubtitle);
    picInut.appendChild(subtitle);
}


function addpeople() {
    var addBtn = document.getElementById('addBtn');

    var hr = document.createElement('hr');

    var img = document.createElement('input');
    var name = document.createElement('input');
    var profile = document.createElement('input');

    img.type = 'file';
    img.name = 'imagefile[]';
    img.className = 'forminline';


    name.type = 'text';
    name.name = 'name[]';
    name.className = 'forminline';

    profile.type = 'text';
    profile.name = 'profile[]';
    profile.className = 'forminline';

    var labelimg = document.createElement('label');
    labelimg.innerHTML = '头像';


    var labeltitle = document.createElement('label');
    labeltitle.innerHTML = '姓名';

    var labelsubtitle = document.createElement('label');
    labelsubtitle.innerHTML = '介绍';

    var picInut = document.getElementById('picInput');
    picInut.appendChild(hr);
    picInut.appendChild(labelimg);
    picInut.appendChild(img);



    picInut.appendChild(labeltitle);
    picInut.appendChild(name);

    picInut.appendChild(labelsubtitle);
    picInut.appendChild(profile);
}


function addcat() {
    var addBtn = document.getElementById('addBtn');

    var hr = document.createElement('hr');

    var img = document.createElement('input');
    var companynames = document.createElement('input');

    img.type = 'file';
    img.name = 'imagefile[]';
    img.className = 'forminline';


    companynames.type = 'text';
    companynames.name = 'cat[]';
    companynames.className = 'forminline';


    var labelimg = document.createElement('label');
    labelimg.innerHTML = '分类图标：';


    var labelcompanyname = document.createElement('label');
    labelcompanyname.innerHTML = '分类名称：';


    var picInput = document.getElementById('picInput');
    var p1 = document.createElement('p');
    var p2 = document.createElement('p');
    picInput.appendChild(p1);
    picInput.appendChild(p2);

    picInput.appendChild(hr);
    picInput.appendChild(p1).appendChild(labelimg);
    picInput.appendChild(p1).appendChild(img);



    picInput.appendChild(p2).appendChild(labelcompanyname);
    picInput.appendChild(p2).appendChild(companynames);

}

*/
var addcatid = 0;
function addcat() {
    this.addcatid++;


    var div = document.getElementById("catalog");
    var p1 = document.createElement('p');
    var prediv = document.createElement('div');
    var p2 = document.createElement('p');
    var hr = document.createElement('hr');

    prediv.id = "precat" + addcatid;
    prediv.className="precat";
    p1.className = "catlogo";






    div.appendChild(p1);
    p1.innerHTML = '<label>分类图标：</label>' + '<input type="button" class="button btncat" value="选择图片" onclick="btnAction(\'catlogo' + addcatid + '\')" />' + 
    ' <input id="catlogo' + addcatid + '" type="file" class="forminline" name="imagefile[]" onchange="readAsDataURL(this.files,\'precat' + addcatid + '\')" />';
    div.appendChild(prediv);
    div.appendChild(p2);
    p2.innerHTML = ' <label>分类名称：</label><input class="forminline btncatname" type="text" name="cat[]" />';
    div.appendChild(hr);

}
function getElements() {
    var x = document.getElementsByTagName("input");
    for (var i = 0; i < x.length; i++) {
        if (x[i].value == "") {
            alert('请将表单填写完成');
            return false; // 有空值
        }
    }
}

function readAsDataURL(file,idname){


    var result=document.getElementById(idname);  
    result.innerHTML = '';
    for(i = 0; i< file.length; i ++) {
        var reader  = new FileReader();    
        reader.readAsDataURL(file[i]);  
        reader.onload=function(e){  
            //多图预览
            result.innerHTML = result.innerHTML + '<img src="' + this.result +'" alt="" />';  
        }

    }
    
}

function btnAction(id) {
    document.getElementById(id).click();
}