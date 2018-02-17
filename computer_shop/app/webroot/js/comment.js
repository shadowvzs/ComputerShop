var Comment = function (commentData) {
	
    var cd = commentData || {};
    var id = cd.id || '';
    var productId = cd.productId || '';
    var userId = cd.userId || '';
    var content = cd.content || '';
    var status = cd.status || '';
    var dateCreated = cd.dateCreated || transformDate(Date.now());
    var userName = cd.userName || '';
    var userEmail = cd.userEmail || '';
    	
    function transformDate (date) {
        return new Date(date).toISOString().slice(0, 19).replace('T', ' ');
    } 
    
    function prettifyDate(date) {
        var today = new Date();
        var date = Date.parse(date);
        var oldDate = new Date(date);
        var timestamp = parseInt((+today - date) / 1000, 10);
    
        if (timestamp < 1) { 
            return "invalid"; 
        } else if (timestamp < 60){
            return "A few seconds ago";
        } else if (timestamp < 600){
            return "A few minutes ago";
        } else if (timestamp < 3600){
            return "Less than an hour ago";
        } else if (timestamp < 604800){
       
            if (oldDate.getDate() === today.getDate()) {
                return "A few hours ago";
            } else {
                var todayTime = today.getHours()*3600
                +today.getMinutes()*60
                +today.getSeconds();
                var yesterdayEvening = +today - (todayTime + 86400) * 1000;
                return (date > yesterdayEvening) ? 'Yesterday' : 'Less than a week ago';
             }
         } else {
            var months;
            var timeA = today.getDate()*86400
                        +today.getHours()*3600
                        +today.getMinutes()*60
                        +today.getSeconds();
            var timeB = oldDate.getDate()*86400
                        +oldDate.getHours()*3600
                        +oldDate.getMinutes()*60
                        +oldDate.getSeconds();
            months = (today.getFullYear() - oldDate.getFullYear()) * 12;
            months -= oldDate.getMonth() + 1;
            months += today.getMonth();
            months += ( timeA < timeB ) ? 0 : 1;

            if (months <= 0) { 
                return "Less than a month ago";
            } else if(months < 5){
                return "A few months ago";
            } else if(months < 12){
                return "Less than a year ago";
            } else {
                return "More than a year ago";
            }
        }
    }
    
    return {
        getId: function () {
            return id;
        },    
        
        getUserName: function () {
            return userName || userEmail;
        },    
        
        setUserName: function(username){
            var resp;
            if (resp = /^[a-zA-Z0-9.\-_ ]{3,30}$/.test(username)) {userName = username;}
            return resp;
        },
        
        getPrettyDate: function () {
            return prettifyDate(dateCreated);
        },    
        
        getDateCreated: function () {
            return dateCreated;
        },       
        
        getContent: function () {
            return content;
        },    
        
        hasNotAllowedWords: function (searchedWord) {
            searchedWord.forEach (function(e){
                if ((new RegExp("\\b"+e+"\\b","ig")).test(content)) {
                    return true;
                }
            });            
            return false;  
        },
        
        replaceNotAllowedWords: function (searchedWords, replacementWords) {
            searchedWords.forEach (function(e, i){
                content = content.replace(new RegExp("\\b"+e+"\\b","ig"), replacementWords[i]);
            });            
            return content;             
        }
    };
  
};

var CommentList = function (listaCommentarii) {
    var comments = [];
	var pageIndex = 0;
    var perPage = 10;
	var postInterval = 10;// required second between post for avoid spam
	var getUrl = "/computer_shop/feedbacks/get";
	var addUrl = "/computer_shop/feedbacks/add";
	var delUrl = "/computer_shop/feedbacks/delete";
	var commentFieldId = "#commentField";
	var clearField = true;	//clear the input field after a comment
	var pagerDivId = "#commentsPager";
	var containerId = "#commentsListDiv";
	var lastComment = null;
	var lastCommentDate = Date.now() - 10000;
	var myId = formData.getUserId();
	var self = this;
	
	if (!listaCommentarii) {
		loadPageFromDB(pageIndex);
	} else {
		comments = initComments(listaCommentarii);
	}
	
    function initComments(listaCommentarii) {
        return listaCommentarii.map(function(commentData) {
            return new Comment(commentData);
        });
    }
    
    function createCommentDiv (id, userName, userId, CreatedDate, Comment){
		var deleteLink = userId != myId ? "&nbsp;&nbsp;&nbsp;" : "<div class='commentDeleteDiv'><a onclick='comments.deleteComment("+id+");'><i class='fa fa-trash'></i></a></div> ";
		return "<div class='clearfix commentDiv' id='comment_"+id+"'>"+deleteLink+"<b>"+userName+"</b> <span class='pull-right commentDate'><i>"+CreatedDate+"</i></span><br>"+Comment+"</div><br>"
	}
    
	function loadPageFromDB(pageIndex) {
		page = pageIndex;
		$.post( getUrl, $.param( { _method: 'POST', data: {
				product_id: formData.getProductId(), 
				page: pageIndex+1, 
				perPage: perPage 
		}}), function(data){
			if (data) {
				if (!data) { return; }
				data = JSON.parse(data);
				var count = data.count;
				var maxIndex = Math.floor(count / perPage);
				var pager = '', prevPage, nextPage;
				var commentsData = data.list;
				var proccessedList = [];
				var commentDiv=$("<div></div>"), newCommentDiv;
				var deleteLink;
				
				if (maxIndex > 0) {
					prevPage = "<button class='btn "+((page > 0) ? "btn-info' onclick='comments.setPage("+(page-1)+");'": "btn-default' disabled")+" > Prev </button>"; 
					nextPage = "<button class='btn "+((page < maxIndex) ? "btn-info' onclick='comments.setPage("+(page+1)+");'": "btn-default' disabled")+"> Next </button>"; 
					
					pager = prevPage+' '+nextPage;
				}
				
				var i = 0, len = commentsData.length, ind, fData, uData, userName;
				for (; i < len; i++) {
					ind = proccessedList.length;
					fData = commentsData[i].Feedback;
					uData = commentsData[i].User;
					userName = uData.first_name+' '+uData.last_name;

					proccessedList[ind] = {
						id: fData.id,
						userName,
						userId: fData.user_id,
						productId: fData.product_id,
						dateCreated: fData.created,
						status: fData.active,
						content: fData.comment
					};
					commentDiv.prepend($(createCommentDiv (fData.id, userName, fData.user_id, fData.created, fData.comment)));
				}

				// replace the old list content with new
				$(containerId).html(commentDiv);
				// create pager
				$(pagerDivId).html(pager);

				comments = initComments(proccessedList);
				
			}else{
				alert('Something went wrong...');
			}
		});		

	}
	
		
    return {
		
		setPage: function(pageIndex) {
			loadPageFromDB(pageIndex);
		},
		
        getCommentsLength: function() {
            return comments.length;
        },
        
        getComment: function(index) {
            return comments[index];
        
        
        },
        
        getCommentById: function(id) {
            return comments.filter(function(e) {
                return e.id() === id;
            });  
        },
                
        getCommentByUser: function(userName) {
            return comments.filter(function(e) {
                return e.getUserName() === userName;
            });   
        },
        

        addComment: function() {
			if (!formData) { return; }
			
			var userId = formData.getUserId();
			var productId = formData.getProductId();
			var userName = formData.getUserName();
			var userEmail = formData.getUserEmail();
			var content = $(commentFieldId).val().trim();
			
			if (!content) {
				alert("Comment field empty!");
				return;
			}
			var timeStamp = Date.now();
			var dateCreated = new Date().toISOString().slice(0, 19).replace('T', ' ');

			var newCommentData = {
				_method: 'POST',
				data: {		
					Feedback: {	
						user_id: userId,
						product_id: productId,
						active: 1,
						comment: content,
						created: dateCreated
					}
				}
			};			

			// we not add new comment if not spent enough second since last or message is same than last message
			if (lastComment === content || (Date.now() < (lastCommentDate + postInterval * 1000))) {
				alert('Do not spam!');
				return; 
			} else {
				lastCommentDate = Date.now();
				lastComment = content;
			}

			$.post( addUrl, $.param( newCommentData ), function(data){
				if (data) {
					
					var next = comments.length;
					comments[next] = {
						id: data,
						userId,
						productId,
						userName,
						userEmail,
						content,
						dateCreated,
						status: 1,
					};

					$(containerId).append($(createCommentDiv(data, userName, userId, dateCreated, content)));
					if (clearField) {
						$(commentFieldId).val('');
					}
					return true;
				}else{
					alert('Error during comment saving...');
				}
			});			
			return false;
        },
		
        deleteComment: function(id) {
			$.post( delUrl, $.param( { _method: 'POST', data: {	id }}), function(data){
				if (data) {
					if (data === "1") {
						$("#comment_"+id).html("<i>deleted</i>");
					} else {
						alert("Unable to delete!");
					}
				}else{
					alert('Something went wrong...');
				}
			});			
        },
		
        editComment: function(id) {
            
        },
		sortByDate: function(direction) {
            if (!/(ASC|DESC)/.test(direction)) { direction = "DESC"; }

            var bool = direction === "DESC";

            comments.sort(function(a, b){
                var keyA = Date.parse(a.getDateCreated()),
                    keyB = Date.parse(b.getDateCreated());
                    
                if(keyA < keyB) return (bool ? 1 : -1);
                if(keyA > keyB) return (bool ? -1 : 1);
                return 0;
            });
            return comments;
        },
       
        getLatestComments: function (date) {

            if (!date) {return false;}
            
            comments.sort(function(a, b){
                var keyA = Date.parse(a.getDateCreated()),
                    keyB = Date.parse(b.getDateCreated());
                    
                if(keyA < keyB) return 1;
                if(keyA > keyB) return -1;
                return 0;
            });
            
            if (!isNaN(parseInt(date, 10)) && typeof date === "number") {
               return comments.slice(0, date);
            }else{

                if (isNaN(Date.parse(date))) { return false;}
                return comments.filter(function(e) {
                    return Date.parse(e.getDateCreated()) > Date.parse(date);
                });                
            }
        }
        
    };
    
};