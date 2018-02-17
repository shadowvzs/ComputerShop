// article e namespaceul meu :)

var article = function (detailsPage){
    
    // maybe too much variable but i think atm enough flexible and easier to configure a bit
    
    var thisArticleId = info.getArticleId();
    var thisAuthorId = info.getAuthorId();
    var myUserId = info.getUserId();
    var myName = info.getUserName();   
    var myEmail = info.getUserEmail();   
    var disableComment = false;
    var disablePagination = false;
    var page = 0;
    var perPage = 2;
    var maxPage = 0;
    var readFrom = 0;   // read comments from this position
    var readTill = 0;   // read comments till here... why? because we want append but dont want read created the whole comment list
    var path = "https://smart-board-shadowvzs.c9users.io/index.php?page=ajax";
    var addUrl = path+"&action=addComment";
    var getUrl = path+"&action=getComments";
    var editUrl = path+"&action=editComment";
    var delUrl = path+"&action=delComment";
    var needAproveComment = true;
    var perPageSelect = document.getElementById("perPage");
    var filterSelect = document.getElementById("statusType");
    var paginationDiv = document.getElementById("pagination");
    var commentListDiv = document.getElementById("commentList");
    var commentCounterDiv = document.getElementById("commentCounter");
    var modalDiv = document.getElementById("modal");
    var orderCommentButton = document.getElementById("commentOrder");
    var addCommentField = document.getElementById("addCommentInput");
    var addCommentButton = document.getElementById("addCommentButton");
    var editCommentField = document.getElementById("editCommentField");
    var editCommentButton = document.getElementById("editCommentButton");
    var showMore = document.getElementById('show_more');
    var editCommentId = null;
    var totalComment = 0;           // how much comment exist at this article, not same than comments length
    var orders = ["DESC", "ASC"];
    var currentOrder = 0;
    var filterStatus = "APROVED";
    var pendingClass = "commentPending";
    var ICONS = {
        CHECKED: "&#9745;",
        UNCHECKED: "&#9744;",
        DELETE: "&#10008;",
        EDIT: "&#9998;"
    };
    var append = detailsPage || false;  //at details page we append to content and not replace
    var comments = null;
    var toolBoxHandler = function (event) {
        var data = event.target.dataset, id, type, cDiv, cData;
        if (!data.id || !data.type) { return; }
        id = data.id;
        type = data.type;
        if (type === "delete") {
            deleteCommentById(id);
        } else if (type === "edit") {
            cDiv = document.getElementById("comment_"+id);
             if (!cDiv) { return; }
            cData = comments.getCommentById(id);
            if (!cData) { return; }
            
            modalDiv.style.display = "block";
            editCommentId = id;
            editCommentField.innerHTML = cData.getContent();
        }else if (type === "status") {
            swapCommentStatus(id);
        }
    };
    

    var addCommentHandler = function(){

        var content = addCommentField.value;
        var status = myUserId == thisAuthorId || !needAproveComment ? 'APROVED' : 'PENDING';

        var data = {
            article_id: thisArticleId,
            user_id: myUserId,
            content: content,
            status: status
        };
        
       var setup = { 
            url: addUrl,
            method: "POST",
            data: {
                comment: data
            }
        };          
        
        toggleComment();
        ajaxRequest (setup, function(data){
            toggleComment();
            if (!data.id || !data.dateCreated) {
                alert("Invalid returned data!");
                return;
            }

            var newComment = {
                id: data.id,
                dateCreated: data.dateCreated,
                userId: myUserId,
                content: content,
                userName: myName,
                status: status,
                userEmail: myEmail,
                articleId: thisArticleId
            };
            
            if (!comments) { 
                comments = new CommentList([newComment]);
            }else{
                comments.addComment(newComment);
            }

            readFrom = readTill;
            readTill++;
            totalComment++;
            setCommentCounter();
            createCommentDiv(true);
            if (status != "APROVED") {
                toggleClass('comment_'+id, pendingClass);
            }

        }, function (data){
            toggleComment();
            alert(data.error || data);
        });
    };
    
    var editCommentHandler = function(event){
        
        var comment = comments.getCommentById(editCommentId); 
 
        if (!comment) {
            alert('Wrong comment id!');
            return false;
        }
        
        var content = editCommentField.value;
    
        if (content.trim() === "") {
            alert('Empty comment message!');
            return false;           
        } else if (content === comment.getContent()){
            alert('Comment message unchanged!');
            return false;             
        }

        
        var data = {
            id: comment.getId(),
            content: content
        };
        
        var setup = { 
            url: editUrl,
            method: "POST",
            data: {
                id: editCommentId,
                comment: data
            }
        };   

        toggleComment();
        ajaxRequest (setup, function(data){
            toggleComment();
            if (!data) {
                alert("Invalid returned data!");
                return;
            }
            
            if (data.updated) {
                editCommentDiv(editCommentId, content);
                comment.setContent(content);
                modalDiv.style.display = "none";
            }
            
        }, function (data){
            toggleComment();
            alert(data.error || data);
        });
    };
    
    var loadNextPageHandler = function() {
        if (!disablePagination) {
            page++;
            loadPage();
        }
    };
    
    var loadPrevPageHandler = function() {
        if (!disablePagination) {
            page--;
            loadPage();
        }
    };    
    
    var orderHandler = function() {
        console.log("1231");
        // for hold temporary this boolean; maybe this is weird
        //but i dont want clear the div, just directly overwrite existing
        //this way avoid a potentional flickering (ex. 100 div -> 0 -> 100)
        var tmp = append; 
        append = false;
        //toggle the order
        currentOrder = 1-currentOrder;
        comments.sortByDate(orders[currentOrder]);
        readFrom = 0;
        readTill = comments.getCommentsLength();
        createCommentDiv();
        readFrom = readTill;
        orderCommentButton.innerHTML = orders[currentOrder];
        append = tmp;
    };
    
    var perPageChangerHandler = function() {
        page = 0;
        perPage = perPageSelect.value;
        loadPage(); 
    };
    
    var filterChangerHandler = function() {
        page = 0;
        filterStatus = filterSelect.value;
        loadPage(); 
    };    
    
    // note if filter or per page changed we load the list again from page 0
    
    if (perPageSelect) {
        perPage = perPageSelect.value;
        addEvent(perPageSelect, "change", perPageChangerHandler);
    }

    if (filterSelect) {
        filterStatus = filterSelect.value;
        addEvent(filterSelect, "change", filterChangerHandler);
    }

    addEvent(showMore, "click", loadNextPageHandler);
    addEvent(orderCommentButton, "click", orderHandler);
    
    function toggleComment() {
        disableComment = !disableComment;
        if (addCommentButton) {
            addCommentButton.disabled = disableComment;
            addCommentField.disabled = disableComment;
        }
        if (editCommentButton) {
            editCommentField.disabled = disableComment;
            editCommentButton.disabled = disableComment;
        }
    }
    
    function toggleClass(dom, cssClass) {
        var obj = typeof dom === "string" ? document.getElementById(dom) : dom;
        if (obj) {
            obj.classList.contains(cssClass) ? obj.classList.remove(cssClass) : obj.classList.add(cssClass);
        }
    } 
        
    
    if (myUserId > 0) {
        addEvent(addCommentButton, "click", addCommentHandler);
        addEvent(editCommentButton, "click", editCommentHandler);
    }
    
    addEvent(commentListDiv, "click", toolBoxHandler);

    function cleanCommentList () {
        maxPage = 0;
        commentCounterDiv.innerHTML = "0";
        setCommentListContent("<center><i>No comment at this article</i></center>");
    }
    
    function setCommentListContent (str){
        commentListDiv.innerHTML = str;
    }
    
    function setPagination(counter) {
        // i also use those 2 variable: page, perPage, maxPage
        var prevPage="", nextPage="", paginator ="", attr;
        maxPage = Math.ceil(counter / perPage); 
        if (maxPage > 1) {
      
            // more fun if i not put eventlistener if not have prev/next page, if no id then no listener
            attr = page > 0 ? "href='javascript:void(0)' id='loadPrevPage'" : "disabled"; 
            prevPage = "<a class='myButton' "+attr+">Prev</a>"; // previous page 
            
            attr = page < (maxPage-1) ? "href='javascript:void(0)' id='loadNextPage'" : "disabled";
            nextPage = "<a class='myButton' "+attr+">Next</a>"; // next page

            paginator = prevPage+' - Page '+(page+1)+' - '+nextPage;
        }

        removeEvent( 'loadPrevPage', 'click', loadPrevPageHandler );
        removeEvent( 'loadNextPage', 'click', loadNextPageHandler );

        paginationDiv.innerHTML = paginator;
        
        addEvent( 'loadPrevPage', 'click', loadPrevPageHandler );
        addEvent( 'loadNextPage', 'click', loadNextPageHandler );
        
    }
    
    // only for short a code a lil
    function removeEvent(dom, type, handler) {
        var obj = typeof dom === "string" ? document.getElementById(dom) : dom;
        if (obj) {
            obj.removeEventListener(type, handler);
        }
    }
    
    function addEvent(dom, type, handler) {
        var obj = typeof dom === "string" ? document.getElementById(dom) : dom;
        if (obj) {
            obj.addEventListener(type, handler);
        }
    }    
    
    function setCommentCounter (){
        commentCounterDiv.innerHTML = totalComment;
    }

    function loadPage () {
        disablePagination = true;
        var setup = { 
            url: getUrl,
            method: "GET",
            data: {
                article_id: thisArticleId,
                index: page,
                limit: perPage,
                status: filterStatus
            }
        };        
        
        ajaxRequest (setup, function(data){

            if (!data.count || data.count < 1 || !data.comments) {
                cleanCommentList();
                if (showMore) {
                    removeEvent(showMore, "click", loadNextPageHandler);
                    showMore.outerHTML = "";
                    showMore = null;           
                }
                return;
            }
            
            
            // lets make comments 
            totalComment = data.count;
            setCommentCounter();

            if (append) {
                readFrom = readTill;
                readTill += data.comments.length;
                !comments ? comments = new CommentList(data.comments) : comments.addComment(data.comments);
                if ((data.count <= perPage) && showMore) {
                    removeEvent(showMore, "click", loadNextPageHandler);
                    showMore.outerHTML = "";
                    showMore = null;
                }

                // append comments
            } else {
                if (data.page) { page = data.page; }
                commentListDiv.innerHTML = "";
                comments = new CommentList(data.comments);
                comments.sortByDate(orders[currentOrder]);
                readFrom = 0;
                readTill = data.comments.length;
                // replace comments
                if (paginationDiv) {
                    setPagination(data.count);
                }                 
                
            }
            
            createCommentDiv(false);
            disablePagination = false;

        }, function (data){
            alert(data.error);
            disablePagination = false;
        });
    }
    
    function createCommentDiv (){
        
        // the idea behind the readFrom and readTill is: dont create everytime a new list, because senseless 
        // rewrite what already exist and what is before readFrom is already exist
        var list = "", id, i = readFrom, comment, userId, toolBox, icon, title, commentClass, aproved;

        if (readFrom < readTill && comments) {
            for (; i < readTill; i++){
                comment = comments.getComment(i);
                id = comment.getId();
                userId = parseInt(comment.getUserId(), 10);
                aproved = comment.getStatus() === 'APROVED';
                commentClass = aproved ? '' : pendingClass;
                if (!detailsPage) {
                    // in dashboard dont need edit comment icon, i add change status icon
                    icon = aproved ? ICONS.CHECKED : ICONS.UNCHECKED;
                    title = 'Click for '+(comment.getStatus() === 'APROVED' ? 'reject' : 'approve');
                    toolBox = (userId !== myUserId && myUserId !== thisAuthorId ) ? '' : `
    			    	<a hred="javascript:void(0);" title="${title}" class="blue" id="status_${id}" data-type="status" data-id="${id}">${icon}</a>
    			    	<a hred="javascript:void(0);" title="Delete" class="red" data-type="delete" data-id="${id}">${ICONS.DELETE}</a>`;
    				
                } else {
                    toolBox = userId !== myUserId ? '' : `
        				<a hred="javascript:void(0);" title="Edit" class="blue" data-type="edit" data-id="${id}">${ICONS.EDIT}</a>
        				<a hred="javascript:void(0);" title="Delete" class="red" data-type="delete" data-id="${id}">${ICONS.DELETE}</a>`;                    
                }


                // well this have a different method too
                // like build with createElement etc but that longer and i think this look better
                // and excuse me if i used here es6 string literal (back ticker), but not better with back ticket?

                list +=`
               	<figure id="comment_${id}" class="${commentClass}">
    				<div class="profile">
    					<img src="public/img/user/${userId}.jpg" alt="profile" onerror="this.onerror=null;this.src='public/img/user/0.jpg';"/>
    				</div>
    				<div class="details">
    					<h4>${comment.getUserName()} 
    					    <span>
                                ${toolBox}
    					    </span>
    					</h4>
    					<p>
    					    <a id="comment_content_${id}">${comment.getContent()}</a>
    					    <span>${comment.getPrettyDate()}</span>
    					</p>
    					
    				</div>
    			</figure>`;                
                
            }
            
            // if we do with append then lets scroll down
        }
        
        if (!append){
           setCommentListContent(list);
        } else {
            commentListDiv.insertAdjacentHTML( 'beforeend', list );
            if (id) {
                var d = document.getElementById("comment_"+id);
                if (d) {
                    d.scrollIntoView();
                }
            }
        }
    }
    
    function removeCommentDiv(id) {
        var div = document.getElementById("comment_"+id);
        if (div) {
            div.outerHTML = "";
        }
       setCommentCounter();
    }
    
    function editCommentDiv(id, newContent) {
        var div = document.getElementById("comment_content_"+id);
        if (div) {
            div.innerHTML = newContent;
        }
        
    }
    
    
    function deleteCommentById(id) {
        
        var index, commentCount;
    
        if (confirm("Are you sure?")) {
             var setup = { 
                url: delUrl,
                method: "GET",
                data: {
                    id: id
                }
            };          
            
     
            ajaxRequest (setup, function(data){
                if (data.deleted) {
                    index = comments.findComment(id);
                    if (index) {
                        if (index <= readFrom && readFrom > 0) {
                          readFrom--;   
                        }
                        comments.deleteComment(index);
                        readTill--;
                    }
                    
                    totalComment--;
                    removeCommentDiv(id);
                    
               }
                
                // autoload the comment page :)       
                if (comments.getCommentsLength() < 2 && maxPage > 0 && !append) {
                    maxPage--;
                    // we decrease the loading page if this is the last/max page index
                    if (maxPage == page) { page--; }
                    loadPage();
                }

            }, function (data){
                alert(data.error || data);
            });            
        }

    }
    
    function swapCommentStatus(id) {
       
        var comment = comments.getCommentById(id), swappedStatus, statusIcon;
        
        if (!comment) {
            alert("Comment not exist");
            return;
        }

        swappedStatus = comment.getStatus() === "APROVED" ? 'rejected' : 'aproved';
        
        if (confirm("Do you want switch to "+swappedStatus+" status")) {
             var setup = { 
                url: editUrl,
                method: "POST",
                data: {
                    comment: {
                        id: id,
                        status: swappedStatus.toUpperCase()
                    }
                }
            };          
            
            ajaxRequest (setup, function(data){

                if (data.updated) {
                    // swap icon and title
                    //change status in comments
                    //ICONS.CHECKED
                    comment.swapStatus();
                    statusIcon = document.getElementById("status_"+id);
                    if (statusIcon) {
                        statusIcon.innerHTML = comment.getStatus() === "APROVED" ? ICONS.CHECKED : ICONS.UNCHECKED;
                        toggleClass('comment_'+id, pendingClass);
                    }
                }

            }, function (data){
                alert(data.error || data);
            });            
        }

    }    
     

    loadPage(); // initial comment load
    
  
    return {
        // no need to return anything :D
    };
    

        
};



