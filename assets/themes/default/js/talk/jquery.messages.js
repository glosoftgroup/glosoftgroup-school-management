if (typeof admin_side === 'undefined')
{
     var admin_side = 0;
}
var cron_id;
function send_message(e, t)
{
     var n = $("textarea.composer").val();
     var r = "id=" + e + "&message=" + n + "&side=" + admin_side;

     if ($.trim(n).length == 0)
     {
          alert($.emptyBox);
     }
     else
     {
          $.ajax({type: "POST", url: t, data: r, cache: false, beforeSend: function ()
               {
                    $("#loadingDiv").show();
               }, error: function ()
               {
                    $("#loadingDiv").hide();
                    $("#errorDiv").html("<p>" + $.ajaxError + "</p>");
               }, success: function (t)
               {
                    $("#loadingDiv").hide();
                    $("p.no-messages").remove();
                    $("#text-messages-request").html(t);
                    $("#text-messages").attr("rel", e);
                    stop_type_status();
               }});
     }
}
function clean_modal()
{
     $(".modal-header h4.modal-title").html("");
     $(".modal-body").html("");
}
function uploadify_init(e, t, n)
{
     var r = $("textarea.composer").val();
     var i = $("input#upload-tm").val();
     $(function ()
     {
          $("#file_upload").uploadify({fileSizeLimit: "20MB", fileTypeExts: e, formData: {timestamp: i, token: $("input#upload-token").val(), upType: n}, swf: "includes/upload/uploadify.swf", uploader: "includes/upload/uploadify", onUploadSuccess: function (e, n, s)
               {
                    $("textarea.composer").val(r + "[" + t + "-" + i + e.name + "]");
                    send_message($("textarea.composer").attr("id"), BASE_URL + "parents/send");
               }, onUploadError: function (e, t, n, r)
               {
                    alert("The file " + e.name + " could not be uploaded: " + r);
               }});
     });
}
function last_seen()
{
     $(window).bind("beforeunload", function ()
     {
          $.post(BASE_URL + "parents/ajax_last_seen", "offline=true", function (e)
          {
          });
     });
     $(window).focus(function ()
     {
          $.post(BASE_URL + "parents/ajax_last_seen", "offline=false", function (e)
          {
          });
     });
}
function update_unMsg_counter(e, t, n, r)
{
     $.post(e, t, function (e)
     {
          $("#unreader-count-" + n).html(e);
          var t = $("#unreader-count-" + n).text();
          if (t.length == 0)
          {
               if (r == "realtime")
               {
                    if (t !== e)
                    {
                                        $("#unreader-counter" + n).html($.unreadMessages + ' <span class="label label-warning" id="unreader-count-' + n + '">1</span>')
                    }
               }
               else
               {
                    $("#unreader-counter" + n).fadeOut(300).text("");
               }
          }
     });
}
function stop_type_status()
{
     var e = BASE_URL + "parents/chat_type_ajax";
     $.post(e, "status=stopped", function (e)
     {
     });
}
function user_is_typing(e, t)
{
     var n = BASE_URL + "parents/chat_type_ajax";
     var r, i = 750;
     $(e).keyup(function ()
     {
          if (typeof r != undefined)
               clearTimeout(r);
          $.post(n, "status=typing_" + t, function (e)
          {
          });
          r = setTimeout(function ()
          {
               $.post(n, "status=stopped", function (e)
               {
               });
          }, i);
     });
}
function type_status(e)
{
     var t = BASE_URL + "parents/chat_type_ajax";
     $.post(t, "id=" + e, function (t)
     {
          if (t == e)
          {
               $("#type-status-" + e).html($.userTypes).css("color", "#009900");
          }
          if (t == "stopped")
          {
               $("#type-status-" + e).html("");
          }
     });
}
function chat_tab()
{
     $.tab = "chats";
     $("#tab-chats").addClass("active-tab");
     $("#tab-contacts").removeClass("active-tab");
     var e = BASE_URL + "parents/list_contacts";
     var t = "post_tabs=chats&side=" + admin_side;
     $.ajax({type: "POST", url: e, data: t, cache: false, beforeSend: function ()
          {
               $("#loadingDiv-chats").show();
          }, error: function ()
          {
               $("#loadingDiv-chats").hide();
               $("#errorDiv").html("<p>" + $.ajaxError + "</p>");
          }, success: function (e)
          {
               $("#loadingDiv-chats").hide();
               $("#messages-stack-list").html(e);
               if (typeof next_tab !== "undefined")
               {
                    $("li#" + tab_id + ".prepare-message").addClass("active-message");
                    if ($("li#" + tab_id + ".prepare-message").hasClass("active-message") == false)
                    {
                         $("#no_chat_users_found").remove();
                         $.newChat = '<li class="prepare-message border-bottom" id="' + tab_id + '">' + cloned_item + "</li>";
                         $("ul#messages-stack-list").append($.newChat);
                         $("li#" + tab_id + ".prepare-message").addClass("active-message");
                    }
               }
          }});
}
function contacts_tab()
{
     $.tab = "contacts";
     $("#tab-contacts").addClass("active-tab");
     $("#tab-chats").removeClass("active-tab");
     var e = BASE_URL + "parents/list_contacts";
     var t = "post_tabs=contacts&side=" + admin_side;
     $.ajax({type: "POST", url: e, data: t, cache: false, beforeSend: function ()
          {
               $("#loadingDiv-contacts").show();
          }, error: function ()
          {
               $("#loadingDiv-contacts").hide();
               $("#errorDiv").html("<p>" + $.ajaxError + "</p>");
          }, success: function (e)
          {
               $("#loadingDiv-contacts").hide();
               $("#messages-stack-list").html(e);
          }});
}
function refresh_chats()
{
     if ($("#tab-" + $.tab).hasClass("active-tab"))
     {
          $("#tab-" + $.tab).addClass("active-tab");
     }
     else
     {
          $("#tab-" + $.tab).removeClass("active-tab");
     }
     var e = BASE_URL + "parents/list_contacts";
     var t = "post_tabs=chats&side=" + admin_side;
     $.ajax({type: "POST", url: e, data: t, cache: false, error: function ()
          {
               $("#errorDiv").html("<p>" + $.ajaxError + "</p>");
          }, success: function (e)
          {
               if ($("#tab-chats").hasClass("active-tab"))
               {
                    $("#messages-stack-list").html(e);
                    if ($.newChat !== undefined)
                    {
                         $("#no_chat_users_found").remove();
                         $("#messages-stack-list").append($.newChat);
                         $.newChat = "";
                    }
               }
          }});
}
function realtime_chat()
{
     last_msg = $(".msg-div").last().attr("data-id");
     var e = $("#text-messages").attr("rel");
      var t = BASE_URL + "parents/refresh_unreadMessages_ajax";
     var n = BASE_URL + "parents/real_time";
      var r = BASE_URL + "parents/chat_last_id";

     var i = "id=" + e + "&last=" + last_msg + "&side=" + admin_side;
     //console.log(i);
     $.post(n, i, function (ee)
     {
          var t = $(e);
          var n = t.attr("id");
          if (e !== last_msg)
          {
               //  if (n !== last_msg) {
               $("#text-messages").append(ee);
          }
     });

     $("ul#messages-stack-list li").each(function ()
     {
          cID = $(this).attr("id");
          cString = "id=" + cID;
          type_status(cID);
         update_unMsg_counter(t, cString, cID, "realtime");
     });
     return false;
}
function google_maps(e, t, n)
{
     function i()
     {
          var t = new google.maps.LatLng(r[0], r[1]);
          var n = {zoom: 16, streetViewControl: false, scaleControl: true, mapTypeId: google.maps.MapTypeId.ROADMAP, center: t};
          map = new google.maps.Map(e, n);
          marker = new google.maps.Marker({position: t, map: map, draggable: false, animation: google.maps.Animation.DROP});
     }
     var r = [t, n];
     i();
}
$.ajaxError = "Failed to proccess request";
$.sendButton = "Send";
$.emptyBox = "Please write something to send";
$.noMessages = "No Messages";
$.noContacts = "No Users";
$.unreadMessages = "Unread";
$.userTypes = "Typing ...";
$.enterIsSend = false;
$.chatOpen = false;
$("ul#messages-stack-list, #text-messages-request, #text-messages").niceScroll({cursorcolor: "#2f2e2e", cursoropacitymax: .6, boxzoom: false, touchbehavior: true});
$("body").on('mousemove', 'textarea', function (e)
{
     var t = $(this).offset();
     t.bottom = $(this).offset().top + $(this).outerHeight();
     t.right = $(this).offset().left + $(this).outerWidth();
     if (t.bottom > e.pageY && e.pageY > t.bottom - 16 && t.right > e.pageX && e.pageX > t.right - 16)
     {
          $(this).css({cursor: "nw-resize"});
     }
     else
     {
          $(this).css({cursor: ""});
     }
}).on("keyup", 'textarea', function (e)
{
     while ($(this).outerHeight() < this.scrollHeight + parseFloat($(this).css("borderTopWidth")) + parseFloat($(this).css("borderBottomWidth")))
     {
          $(this).height($(this).height() + 1);
     }
});
$("body").on('click', '#tab-contacts', function (e)
{
     contacts_tab();
     e.preventDefault();
});
$("body").on('click', '#tab-chats', function (e)
{
     chat_tab();
     e.preventDefault();
});
$(".load-more-contacts").off("click").on("click", function ()
{
     var e = $(this).attr("id");
     var t = $(this).attr("rel");
     var n = BASE_URL + "parents/contacts_more_ajax";
     var r = BASE_URL + "parents/refresh_unreadMessages_ajax";
     var i = "lastid=" + e + "&uid=" + t + "&tab=" + $.tab + "&side=" + admin_side;
     if (e)
     {
          $.ajax({type: "POST", url: n, data: i, cache: false, beforeSend: function ()
               {
                    $("#more-contacts" + e).html('<img src="' + BASE_URL + 'assets/ico/sm-loader.gif" />');
               }, error: function ()
               {
                    $("#loadingDiv").hide();
                    $("#errorDiv").html("<p>" + $.ajaxError + "</p>");
               }, success: function (n)
               {
                    $("#loadingDiv").hide();
                    $("div#more-contacts" + e + ".more-contacts-parent").remove();
                    $("#messages-stack-list").append(n);
                    update_unMsg_counter(r, i, t, "");
               }});
     }
     else
     {
          $("#more-contacts").html($.noContacts);
     }
     return false;
});

$("body").on('click', 'li.prepare-message', function ()
{

     $.chatOpen = true;
     var e = $(this).attr("id");
     var t = BASE_URL + "parents/fetch_log";
     var n = BASE_URL + "parents/refresh_unreadMessages_ajax";
     var r = "id=" + e + "&side=" + admin_side;
     $.ajax({type: "POST", url: t, data: r, cache: false, beforeSend: function ()
          {
               $("#loadingDiv").show();
          }, error: function ()
          {
               $("#loadingDiv").hide();
               $("#errorDiv").html("<p>" + $.ajaxError + "</p>");
          }, success: function (t)
          {
               $("#loadingDiv").hide();
               $("#contacts-search-input").val("");
               $(".active-message").removeClass("active-message");
               $("li#" + e + ".prepare-message").focus().addClass("active-message");
               $("#text-messages-request").html(t);
               $("#text-messages").attr("rel", e);
               if ($.tab == "contacts")
               {
                    cloned_item = $("li#" + e + ".prepare-message").html();
                    $.when(chat_tab()).done(function ()
                    {
                         next_tab = "chats";
                         tab_id = e;
                    });
               }
               update_unMsg_counter(n, r, e, "");
               cron(false);
               cron(true);
          }});

     return false;
});
$("body").on('click', 'textarea.composer', function ()
{
     var e = $(this).attr("id");
     var t = BASE_URL + "parents/send";
     $("div.message-btn-target").html('<a href="javascript:" id="' + e + '" class="btn btn-custom btn-sm send-message"><i class="glyphicon glyphicon-send"></i> ' + $.sendButton + "</a>");
     $("#type-a-message").remove();
     user_is_typing(this, e);
     $(this).on("blur", function ()
     {
          stop_type_status();
     });
     if ($.enterIsSend == true)
     {
          $(this).keypress(function (n)
          {
               if (n.which == 13)
               {
                    send_message(e, t);
               }
          });
          $("a.send-message").on("click", function ()
          {
               send_message(e, t);
          });
     }
     else
     {
          $("a.send-message").on("click", function ()
          {
               send_message(e, t);
          });
     }
     return false;
});
$(".load-more-messages").off("click").on("click", function ()
{
     var e = $(this).attr("id");
     var t = $(this).attr("rel");
     var n = BASE_URL + "parents/chat_more_ajax";
     var r = BASE_URL + "parents/refresh_unreadMessages_ajax";
     var i = "lastid=" + e + "&uid=" + t + "&side=" + admin_side;
     if (e)
     {
          $.ajax({type: "POST", url: n, data: i, cache: false, beforeSend: function ()
               {
                    $("#more" + e).html('<img src="' + BASE_URL + 'assets/ico/sm-loader.gif" />');
               }, error: function ()
               {
                    $("#loadingDiv").hide();
                    $("#errorDiv").html("<p>" + $.ajaxError + "</p>");
               }, success: function (n)
               {
                    $("#loadingDiv").hide();
                    $("div#more" + e + ".more-messages-parent").remove();
                    $("#text-messages").append(n);
                    update_unMsg_counter(r, i, t, "");
               }});
     }
     else
     {
          $("#more").html($.noMessages);
     }
     return false;
});
$("#contacts-search-input").on("click", function ()
{
     var e = $("ul#messages-stack-list").html();
     $("#tab-chats").removeClass("active-tab");
     $("#tab-contacts").removeClass("active-tab");
     $(this).keyup(function ()
     {
          var e = $(this).val();
          var t = "filterword=" + e + "&side=" + admin_side;
          var n = BASE_URL + "parents/chat_filter_ajax";
          if ($.trim(e).length > 0)
          {
               $.ajax({type: "POST", url: n, data: t, cache: false, beforeSend: function ()
                    {
                         $("#loadingDiv").show();
                    }, error: function ()
                    {
                         $("#loadingDiv").hide();
                         $("#errorDiv").html("<p>" + $.ajaxError + "</p>");
                    }, success: function (e)
                    {
                         $("#loadingDiv").hide();
                         $("ul#messages-stack-list").html(e).show();
                    }});
          }
          return false;
     });
     $("ul#messages-stack-list").mouseup(function ()
     {
          return false;
     });
     $(document).mouseup(function ()
     {
          $("#contacts-search-input").val("");
          $.tab = "chats";
          $("#tab-chats").addClass("active-tab");
          $("#tab-contacts").removeClass("active-tab");
     });
});
$(".remove-message").off("click").on("click", function ()
{
     var e = $(this).attr("id");
     var t = $(this).data("user");
     var n = BASE_URL + "parents/chat_remove_ajax";
     var r = "id=" + e + "&uid=" + t + "&side=" + admin_side;
     $.ajax({type: "POST", url: n, data: r, cache: false, beforeSend: function ()
          {
               $("#loadingDiv").show();
          }, error: function ()
          {
               $("#loadingDiv").hide();
               $("#errorDiv").html("<p>" + $.ajaxError + "</p>");
          }, success: function (t)
          {
               $("#loadingDiv").hide();
               $("#u_msg" + e).remove();
               var n = parseInt($("span#count-old-messages").text());
               $("span#count-old-messages").html(n - 1);
               if (n == 1)
               {
                    $(".more-messages-parent").fadeOut(300).remove();
               }
          }});
     return false;
});
$("body").on('click', '#emoticons', function ()
{
     $(".modal-header h4.modal-title").html("Emoticons");
     $(".modal-body").html('<img class="emoticons" src="img/emoticons/Angry.png" id="angry" data-value=":@">' + '<img class="emoticons" src="img/emoticons/Balloon.png" id="balloon" data-value="[balloon]">' + '<img class="emoticons" src="img/emoticons/Big-Grin.png" id="big-grin" data-value="[big-grin]">' + '<img class="emoticons" src="img/emoticons/Bomb.png" id="bomb" data-value="[bomb]">' + '<img class="emoticons" src="img/emoticons/Broken-Heart.png" id="broken-heart" data-value="[broken-heart]">' + '<img class="emoticons" src="img/emoticons/Cake.png" id="cake" data-value="[cake]">' + '<img class="emoticons" src="img/emoticons/Cat.png" id="cat" data-value="[cat]">' + '<img class="emoticons" src="img/emoticons/Clock.png" id="clock" data-value="[clock]">' + '<img class="emoticons" src="img/emoticons/Clown.png" id="clown" data-value="[clown]">' + '<img class="emoticons" src="img/emoticons/Cold.png" id="cold" data-value="[cold]">' + '<img class="emoticons" src="img/emoticons/Confused.png" id="confused" data-value="[confused]">' + '<img class="emoticons" src="img/emoticons/Cool.png" id="cool" data-value="[cool]">' + '<img class="emoticons" src="img/emoticons/Crying.png" id="crying" data-value="[crying]">' + '<img class="emoticons" src="img/emoticons/Crying2.png" id="crying2" data-value="[crying2]">' + '<img class="emoticons" src="img/emoticons/Dead.png" id="dead" data-value="[dead]">' + '<img class="emoticons" src="img/emoticons/Devil.png" id="devil" data-value="[devil]">' + '<img class="emoticons" src="img/emoticons/Dizzy.png" id="dizzy" data-value="[dizzy]">' + '<img class="emoticons" src="img/emoticons/Dog.png" id="dog" data-value="[dog]">' + '<img class="emoticons" src="img/emoticons/Don\'t-tell-Anyone.png" id="dont-tell-anyone" data-value="[dont-tell-anyone]">' + '<img class="emoticons" src="img/emoticons/Drinks.png" id="drinks" data-value="[drinks]">' + '<img class="emoticons" src="img/emoticons/Drooling.png" id="drooling" data-value="[drooling]">' + '<img class="emoticons" src="img/emoticons/Flower.png" id="flower" data-value="[flower]">' + '<img class="emoticons" src="img/emoticons/Ghost.png" id="ghost" data-value="[ghost]">' + '<img class="emoticons" src="img/emoticons/Gift.png" id="gift" data-value="[gift]">' + '<img class="emoticons" src="img/emoticons/Girl.png" id="girl" data-value="[girl]">' + '<img class="emoticons" src="img/emoticons/Goodbye.png" id="goodbye" data-value="[goodbye]">' + '<img class="emoticons" src="img/emoticons/Heart.png" id="heart" data-value="[heart]">' + '<img class="emoticons" src="img/emoticons/Hug.png" id="hug" data-value="[hug]">' + '<img class="emoticons" src="img/emoticons/Kiss.png" id="kiss" data-value="[kiss]">' + '<img class="emoticons" src="img/emoticons/Laughing.png" id="laughing" data-value="[laughing]">' + '<img class="emoticons" src="img/emoticons/Ligthbulb.png" id="lightbulb" data-value="[lightbulb]">' + '<img class="emoticons" src="img/emoticons/Loser.png" id="loser" data-value="[loser]">' + '<img class="emoticons" src="img/emoticons/Love.png" id="love" data-value="[love]">' + '<img class="emoticons" src="img/emoticons/Mail.png" id="mail" data-value="[mail]">' + '<img class="emoticons" src="img/emoticons/Music.png" id="music" data-value="[music]">' + '<img class="emoticons" src="img/emoticons/Nerd.png" id="nerd" data-value="[nerd]">' + '<img class="emoticons" src="img/emoticons/Night.png" id="night" data-value="[night]">' + '<img class="emoticons" src="img/emoticons/Ninja.png" id="ninja" data-value="[ninja]">' + '<img class="emoticons" src="img/emoticons/Not-Talking.png" id="not-talking" data-value="[not-talking]">' + '<img class="emoticons" src="img/emoticons/on-the-Phone.png" id="on-the-phone" data-value="[on-the-phone]">' + '<img class="emoticons" src="img/emoticons/Party.png" id="party" data-value="[party]">' + '<img class="emoticons" src="img/emoticons/Pig.png" id="pig" data-value="[pig]">' + '<img class="emoticons" src="img/emoticons/Poo.png" id="poo" data-value="[poo]">' + '<img class="emoticons" src="img/emoticons/Rainbow.png" id="rainbow" data-value="[rainbow]">' + '<img class="emoticons" src="img/emoticons/Rainning.png" id="rainning" data-value="[rainning]">' + '<img class="emoticons" src="img/emoticons/Sacred.png" id="sacred" data-value="[sacred]">' + '<img class="emoticons" src="img/emoticons/Sad.png" id="sad" data-value=":(">' + '<img class="emoticons" src="img/emoticons/Scared.png" id="scared" data-value="[scared]">' + '<img class="emoticons" src="img/emoticons/Sick.png" id="sick" data-value="[sick]">' + '<img class="emoticons" src="img/emoticons/Sick2.png" id="sick2" data-value="[sick2]">' + '<img class="emoticons" src="img/emoticons/Silly.png" id="silly" data-value="[silly]">' + '<img class="emoticons" src="img/emoticons/Sleeping.png" id="sleeping" data-value="[sleeping]">' + '<img class="emoticons" src="img/emoticons/Sleeping2.png" id="sleeping2" data-value="[sleeping2]">' + '<img class="emoticons" src="img/emoticons/Sleepy.png" id="sleepy" data-value="[sleepy]">' + '<img class="emoticons" src="img/emoticons/Sleepy2.png" id="sleepy2" data-value="[sleepy2]">' + '<img class="emoticons" src="img/emoticons/smile.png" id="smile" data-value=":)">' + '<img class="emoticons" src="img/emoticons/Smoking.png" id="smoking" data-value="[smoking]">' + '<img class="emoticons" src="img/emoticons/Smug.png" id="smug" data-value="[smug]">' + '<img class="emoticons" src="img/emoticons/Stars.png" id="stars" data-value="[stars]">' + '<img class="emoticons" src="img/emoticons/Straight-Face.png" id="straight-face" data-value="[straight-face]">' + '<img class="emoticons" src="img/emoticons/Sun.png" id="sun" data-value="[sun]">' + '<img class="emoticons" src="img/emoticons/Sweating.png" id="sweating" data-value="[sweating]">' + '<img class="emoticons" src="img/emoticons/Thinking.png" id="thinking" data-value="[thinking]">' + '<img class="emoticons" src="img/emoticons/Tongue.png" id="tongue" data-value="[tongue]">' + '<img class="emoticons" src="img/emoticons/Vomit.png" id="vomit" data-value="[vomit]">' + '<img class="emoticons" src="img/emoticons/Wave.png" id="wave" data-value="[wave]">' + '<img class="emoticons" src="img/emoticons/Whew.png" id="whew" data-value="[whew]">' + '<img class="emoticons" src="img/emoticons/Win.png" id="win" data-value="[win]">' + '<img class="emoticons" src="img/emoticons/Winking.png" id="winking" data-value="[winking]">' + '<img class="emoticons" src="img/emoticons/Yawn.png" id="yawn" data-value="[yawn]">' + '<img class="emoticons" src="img/emoticons/Yawn2.png" id="yawn2" data-value="[yawn2]">' + '<img class="emoticons" src="img/emoticons/Zombie.png" id="zombie" data-value="[zoombie]">');
     $("#generalModal").modal("show");
     $(".emoticons").on("click", function ()
     {
          var e = $(this).attr("id");
          var t = $(this).data("value");
          var n = $("textarea.composer").val();
          $("textarea.composer").val(n + t);
          $("#generalModal").modal("hide");
          clean_modal();
     });
});
$("body").on('click', '#send-photo', function ()
{
     $(".modal-header h4.modal-title").html("Attach Photos");
     $(".modal-body").html('<input type="file" name="file_upload" id="file_upload" /><br /><br /><p>Note: Allowed files are .gif, .png, .jpg Limited to 20MB<p/>');
     uploadify_init("*.gif; *.jpg; *.png", "photoAttachment", "images");
     $("#generalModal").modal("show");
});
$("body").on('click', '#send-file', function ()
{
     $(".modal-header h4.modal-title").html("Attach Files");
     $(".modal-body").html('<input type="file" name="file_upload" id="file_upload" /><br /><br /><p>Note: Allowed files are .zip, .pdf, .doc, .ptt, .txt, .xls, .docx, .xlsx, .pptx Limited to 20MB<p/>');
     uploadify_init("*.zip; *.pdf; *.doc; *.ppt; *.xls; *.txt; *.docx; *.xlsx; *.pptx", "fileAttachment", "files");
     $("#generalModal").modal("show");
});
$("body").on('click', '#send-location', function ()
{
     $(".modal-header h4.modal-title").html("Google Map Location");
     $(".modal-body").html("<p>Insert a google map coordinate:</p>" + '<div class="form-group">' + '<div class="input-group">' + '<div class="input-group-addon">Latitude</div>' + '<input type="text" class="form-control input-sm" id="maps_latitude">' + "</div>" + "</div>" + '<div class="form-group">' + '<div class="input-group">' + '<div class="input-group-addon">Longitude</div>' + '<input type="text" class="form-control input-sm" id="maps_longitude">' + "</div>" + "</div>");
     $(".modal-footer").html('<input type="buttun" id="send-location-btn" class="btn btn-primary" value="Send" />');
     $("#generalModal").modal("show");
     $("#send-location-btn").on("click", function ()
     {
          var e = "[Location=" + $("#maps_latitude").val() + ", " + $("#maps_longitude").val() + "]";
          $("textarea.composer").val(e);
          send_message($("textarea.composer").attr("id"), BASE_URL + "parents/send");
     });
});

function cron(flag)
{
     if ($('.placer').length < 1)
     {
          if (flag)
          {
               cron_id = setInterval(realtime_chat, 8000);//7e3
          }
          else
          {
               clearInterval(cron_id);
          }

     }
}

//setInterval("refresh_chats()", 1e4);
//last_seen();