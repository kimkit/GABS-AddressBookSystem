<?php
session_start();
?>
<script type="text/javascript" src="<?php $_SERVER['DOCUMENT_ROOT']?>/src/js/jquery-1.12.0.min.js"></script>
<script type="text/javascript" src="<?php $_SERVER['DOCUMENT_ROOT']?>/src/js/layui/layui.js"></script>
<script type="text/javascript" src="<?php $_SERVER['DOCUMENT_ROOT']?>/src/js/common.js"></script>
<script type="text/javascript" src="<?php $_SERVER['DOCUMENT_ROOT']?>/src/js/simple-watermark.js"></script>
<script type="text/javascript" src="<?php $_SERVER['DOCUMENT_ROOT']?>/src/js/pinyin.js"></script>
<script type="text/javascript" src="<?php $_SERVER['DOCUMENT_ROOT']?>/src/js/clipboard.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php $_SERVER['DOCUMENT_ROOT']?>/src/js/layui/css/layui.css"/>
<link rel="stylesheet" type="text/css" href="<?php $_SERVER['DOCUMENT_ROOT']?>/src/view/editIframe.css"/>

<div class="wrap">
  <form class="layui-form layui-form-pane" onsubmit="return false">
    <div class="left">
      <div class="layui-form-item">
        <label class="layui-form-label"><span lang="姓名"></span></label>
        <div class="layui-input-inline">
          <input type="text" name="姓名" required  lay-verify="required" placeholder="" value="" autocomplete="off" class="layui-input">
        </div>
      </div>
      <div class="layui-form-item">
        <label class="layui-form-label"><span lang="拼音"></span></label>
        <div class="layui-input-inline">
          <input type="text" name="拼音" required lay-verify="required" placeholder="" value="" autocomplete="off" class="layui-input">
        </div>
      </div>
      <div class="layui-form-item">
        <label class="layui-form-label"><span lang="公司"></span></label>
        <div class="layui-input-inline">
          <input type="text" name="公司" placeholder="" value="" autocomplete="off" class="layui-input">
        </div>
      </div>
      <div class="layui-form-item">
        <label class="layui-form-label"><span lang="手机"></span></label>
        <div class="layui-input-inline">
          <input type="text" name="手机" placeholder="" value="" autocomplete="off" class="layui-input">
        </div>
      </div>
      <div class="layui-form-item">
        <label class="layui-form-label"><span lang="座机"></span></label>
        <div class="layui-input-inline">
          <input type="text" name="座机" placeholder="" value="" autocomplete="off" class="layui-input">
        </div>
      </div>
      <div class="layui-form-item">
        <label class="layui-form-label"><span lang="邮箱"></span></label>
        <div class="layui-input-inline">
          <input type="text" name="邮箱" placeholder="" value="" autocomplete="off" class="layui-input">
        </div>
      </div>
      <div class="layui-form-item">
        <label class="layui-form-label"><span lang="备注"></span></label>
        <div class="layui-input-inline">
          <input type="text" name="备注" placeholder="" value="" autocomplete="off" class="layui-input">
        </div>
      </div>
      <div class="layui-form-item">
        <label class="layui-form-label"><span lang="权限"></span></label>
        <div class="layui-input-inline" style="width:185px !important">
          <input type="text" name="组" placeholder="私有" value="" autocomplete="off" class="layui-input">
        </div>
        <div class="layui-input-inline" style="width:50px !important">
          <input type="checkbox" name="权限" lay-skin="switch" lay-text="编辑|只读">
        </div>
      </div>
      <div class="layui-form-item">
        <div class="layui-btn-group button-wrap">
          <div class="layui-btn layui-btn-primary" id="cancel"><span lang="关闭"></span></div>
        </div>
      </div>
    </div>
    
    <div class="right">
      <div class="layui-form-item sex" pane>
        <label class="layui-form-label"><span lang="性别"></span></label>
          <div class="layui-input-inline">
            <input type="radio" name="性别" value="男" title="男" data-lang="男">
            <input type="radio" name="性别" value="女" title="女" data-lang="女">
            <input type="radio" name="性别" value="" title="未知" checked data-lang="未知">
          </div>
      </div>
      <div class="layui-form-item">
        <label class="layui-form-label"><span lang="身份证号码"></span></label>
        <div class="layui-input-inline">
          <input type="text" name="身份证号码" required lay-verify="required" placeholder="" value="" autocomplete="off" class="layui-input">
        </div>
      </div>
      <div class="JS-showAddItem"></div>
      <div class="layui-form-item">
        <div class="layui-btn" id="addInfo"><span class="layui-icon">&#xe654;</span><span lang="增加条目"></span></div>
      </div>
    </div>
    
  </form>
  

</div>
<script>

//初始化layui表单组件
layui.use('form', function(){
  var form = layui.form;
  
  //显示数据
  var GUID = parent.GUID; 
  editAjax('XiangXi');
  function editAjax(action){
    $.ajax({
      url:rootpath+"/src/controller/list_controller.php",
      async:false,
      type: 'post',
      data: {
        action:action,
        GUID:GUID
      },
      beforeSend:function(){
        loadingDiv('load');
      },
      success:function(res){
        loadingDiv();
        if(res!=''&&res!=null){
          res = JSON.parse(res);
          //如果数据权限是2或数据是本人的，启用编辑按钮
          if(res.USER_ID =='<?php echo $_SESSION['USER_ID']; ?>'||res.QUAN_XIAN ==2){
            $('#cancel').before('<div class="layui-btn" id="edit"><span class="layui-icon">&#xe642;</span><span lang="启用编辑"></span></div>');

          }

          if(res.QUAN_XIAN ==2){
            $('input[name="权限"]').attr('checked','checked');
            form.render();
          }
          $('input[name="姓名"]').val(res.data[0].XING_MING);  //显示姓名
          
          if(res.ZU_NAME!=null&&res.ZU_ID!=null){
            $('input[name="组"]').val(res.ZU_NAME+'['+res.ZU_ID+']');  //显示组
          }

          $('.JS-showAddItem').html('');
          
          for(i=0;i<res.data.length;i++){
            if(res.data[i].XIANG_MU == '拼音'){
              $('input[name="拼音"]').val(res.data[i].NEI_RONG);  //显示拼音
            }else if(res.data[i].XIANG_MU == '公司'){
              $('input[name="公司"]').val(res.data[i].NEI_RONG);  //显示公司
            }else if(res.data[i].XIANG_MU == '手机'){
              $('input[name="手机"]').val(res.data[i].NEI_RONG);  //显示手机
            }else if(res.data[i].XIANG_MU == '座机'){
              $('input[name="座机"]').val(res.data[i].NEI_RONG);  //显示座机
            }else if(res.data[i].XIANG_MU == '邮箱'){
              $('input[name="邮箱"]').val(res.data[i].NEI_RONG);  //显示邮箱
            }else if(res.data[i].XIANG_MU == '备注'){
              $('input[name="备注"]').val(res.data[i].NEI_RONG);  //显示备注
            }else if(res.data[i].XIANG_MU == '性别'){
              $('input[name="性别"][value='+res.data[i].NEI_RONG+']').attr("checked",true);  //显示性别
              form.render('radio');
            }else if(res.data[i].XIANG_MU == '身份证号码'){
              $('input[name="身份证号码"]').val(res.data[i].NEI_RONG);  //显示身份证号码
            }else{
              infoHtml = '<div class="layui-form-item addItem">'+
                           '<label class="layui-form-label">'+
                             '<input type="text" value="'+res.data[i].XIANG_MU+'" class="info-input">'+
                           '</label>'+
                           '<div class="layui-input-inline">'+
                             '<input type="text" name="'+res.data[i].XIANG_MU+'" placeholder="" value="'+res.data[i].NEI_RONG+'" autocomplete="off" class="layui-input">'+
                           '</div>'+
                         '</div>';
              $('.JS-showAddItem').append(infoHtml);
            }
            $('input').attr('disabled','disabled');  //禁用编辑
            $('select').attr('disabled','disabled');  //禁用编辑
            $('#addInfo').hide();  //隐藏添加条目
            $('#save').remove();  //删除保存按钮
            $('#delete').remove();  //删除删除按钮
            
            
          }
          
          initLang('editIframe','<?php echo $_SESSION['lang']; ?>');
          
          //启用编辑按钮点击事件
          $('#edit').click(function(){
            $(this).remove();
            //增加保存按钮
            $('#cancel').before('<button class="layui-btn layui-btn-normal" id="save"><span class="layui-icon">&#xe67c;</span><span lang="保存"></span></button>');
            //增加删除按钮
            $('#cancel').before('<button class="layui-btn layui-btn-danger" id="delete"><span class="layui-icon">&#xe640;</span><span lang="删除"></span></button>');

            $('input').removeAttr('disabled');  //启用编辑
            if(res.USER_ID !='<?php echo $_SESSION['USER_ID']; ?>'){
              $('input[name="组"]').attr('readonly','readonly').unbind('click').css('opacity','0.5');  //禁用组修改
              $('.layui-form-switch').unbind('click').css('opacity','0.5');  //禁用权限修改
            }

            $('#addInfo').show();  //可以添加条目
            $('.addItem').append('<div class="delBtn"><span class="layui-icon">&#x1006;</span></div>');
            
            initLang('editIframe','<?php echo $_SESSION['lang']; ?>');
            
          });
          
        }else{
          layer.msg('数据获取失败!');
        }

      },
      error:function(e){
        layer.msg(e);
      }
    });
  }

  
  //初始化语言函数
  function initLang(pageName,lang){
    ajax=$.ajax({
      url:rootpath+"/src/controller/lang_controller.php",
      type: 'post',
      async:true,
      data: {
        pageName:pageName,
        lang:lang
      },
      success:function(res){
        res = JSON.parse(res);
        for(i=0;i<res.length;i++){
          $('span[lang="'+res[i]['XuHao']+'"]').html(res[i]['WenZi']);
          
          switch(res[i]['XuHao']){
            case '男':
              $('input[data-lang="男"]').attr('title',res[i]['WenZi']);
              form.render('radio');
            break;
            case '女':
              $('input[data-lang="女"]').attr('title',res[i]['WenZi']);
              form.render('radio');
            break;
            case '未知':
              $('input[data-lang="未知"]').attr('title',res[i]['WenZi']);
              form.render('radio');
            break;
          }
        }
        
      }
    });
  }
 
  
  //保存按钮点击事件
  $('body').on('click', '#save', function(){
    if($('input[name="姓名"]').val()!=''&&$('input[name="拼音"]').val()!=''&&$('input[name="身份证号码"]').val()!=''){
      action = 'BaoCun';
      formData = $('.layui-form').serialize();
      ajax = $.ajax({
        url:rootpath+"/src/controller/list_controller.php",
        async:true,
        type: 'post',
        data: {
          action:action,
          formData:formData,
          GUID:GUID
        },
        beforeSend:function(){
          loadingDiv('load');
        },
        success:function(res){
          loadingDiv();
          if(res=='ok'){
            parent.layer.msg('保存成功');
            parent.tableRef = true;
            editAjax('XiangXi');
          }
          
        }
      });
    }
  });

  //删除按钮点击事件
  $('body').on('click', '#delete', function(){
    layer.confirm('删除 - Delete',{
        btn: ['Yes', 'No'],
        time: 0,
        title:''
      }, function(){
        action = 'ShanChu';
        ajax = $.ajax({
          url:rootpath+"/src/controller/list_controller.php",
          async:true,
          type: 'post',
          data: {
            action:action,
            GUID:GUID
          },
          beforeSend:function(){
            loadingDiv('load');
          },
          success:function(res){
            loadingDiv();
            if(res=='ok'){
              parent.layer.closeAll();
              parent.tableRef = true;
              parent.layer.msg('删除成功');
            }
          }
        });
      }
    );

  });
  
  //取消按钮点击事件
  $('#cancel').click(function(){
    //当你在iframe页面关闭自身时
    var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
    parent.layer.close(index); //再执行关闭   
  });

  //增加条目点击事件
  $('#addInfo').click(function(){
    var self = $(this);
    infoHtml = '<div class="layui-form-item addItem">'+
                 '<label class="layui-form-label">'+
                   '<input type="text" value="" class="info-input">'+
                 '</label>'+
                 '<div class="layui-input-inline">'+
                   '<input type="text" name="" placeholder="" value="" autocomplete="off" class="layui-input">'+
                 '</div>'+
                 '<div class="delBtn"><span class="layui-icon">&#x1006;</span></div>'+
               '</div>';
    $('.JS-showAddItem').append(infoHtml);
  });

  //增加条目-名称输入监听
  $('body').on('blur', '.info-input', function(){
    var self = $(this);
    self.parent().parent().find('.layui-input').attr('name',self.val());
    
  });

  //增加条目-鼠标移入监听-显示删除按钮
  $('body').on('mouseover', '.addItem', function(){
    var self = $(this);
    self.find('.delBtn').show();
  });
  $('body').on('mouseout', '.addItem', function(){
    var self = $(this);
    self.find('.delBtn').hide();
  });

  //增加条目-删除按钮点击事件
  $('body').on('click', '.delBtn', function(){
    var self = $(this);
    self.parent().remove();
  });

  var inputStat = 0;
  //姓名输入监听，拼音同步显示
  $('input[name="姓名"]').bind('input propertychange', function() {
    var self = $(this);
    nameVal = $('input[name="姓名"]').val();
    var pinyinRes = '';
    for(i=0;i<nameVal.length;i++){
      
      pinyinRes += getPinyin(nameVal[i]);
      
      function getPinyin(nameVal){
        var res = nameVal;
        for( var key in pinyin){
          if(key==nameVal){
            res = pinyin[key];
          }
        }
        return res;
      }

    }
    $('input[name="拼音"]').val(pinyinRes);
    
  });
  
  //选择组输入框点击事件 - 弹出组选择窗口
  $('input[name="组"]').click(function(){
    //打开组选择弹出层
    parent.layer.open({
      type: 2,
      title: '',
      shade: 0.4,
      closeBtn:0,
      area: ['540px','540px'],
      content: rootpath+'/src/view/zuIframe.php',
      end:function(){
        if(getCookie('ztext')=='cancel'){
        }else if(getCookie('ztext')!=''){
          $('input[name="组"]').val(getCookie('ztext'));
          $('input[name="权限"]').removeAttr('disabled');
        }else{
          $('input[name="组"]').val('');
          $('input[name="权限"]').attr('disabled','disabled');
        }
        form.render();
      }
    }); 
  });
  
  //通讯录表格移入事件 - 显示复制按钮
  $('body').on('mouseenter', '.layui-input-inline', function (){
    var self = $(this);
    var text = self.find('input').val();
    self.append('<div class="iconfont icon-copy" data-clipboard-text="'+text+'">&#xe633;</div>');

  });
  $('body').on('mouseleave', '.layui-input-inline', function (){
    var self = $(this);
    self.find('.iconfont').remove();
  });
  
  var clipboard = new Clipboard('.icon-copy');

  clipboard.on('success', function(e) {
      layer.msg('已复制到粘贴板：'+e.text);

      e.clearSelection();
  });
  
});

    new Watermark({
      fillStyle: 'rgba(184, 184, 184, .4)',
      fillText: '<?php echo $_SESSION['USER_NAME']; ?>',
    });



</script>
