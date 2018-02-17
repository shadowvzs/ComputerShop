var Comment = function (commentData) {
    var cd = commentData || {};
    var id = cd.id || '';
    var articleId = cd.articleId || '';
    var userId = cd.userId || '';
    var content = cd.content || '';
    var status = cd.status || 'PENDING';
    var dateCreated = cd.dateCreated || transformDate(Date.now());
    var userName = cd.userName || 'Deleted';
    var userEmail = cd.userEmail || 'Deleted';
    
    if (isNaN(parseInt(userId, 10))) {
        userId = 0;
    }
    
    if (!/[1-2]{1}[0-9]{3}\-[0-9]{2}\-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}/g.test(dateCreated)) {
        dateCreated = transformDate(Date.now());
    }
    // dateCreated = dateCreated instanceof Date && !isNaN(dateCreated) ? dateCreated : transformDate(Date.now());


    function transformDate (date) {
        return new Date().toISOString().slice(0, 19).replace('T', ' ');
    } 
    
    function prettifyDate(givenDate) {
        var today = new Date();
        var date = Date.parse(givenDate);
        var oldDate = new Date(date);
        var timestamp = parseInt((+today - date) / 1000, 10);
        
        if (timestamp < 0) { timestamp = 0; }

        if (timestamp < 1) { 
            return "Now"; 
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
        
        getStatus: function() {
            return status;
        },
        
        swapStatus: function() {
            status = (status === "APROVED") ? 'REJECTED' : 'APROVED';
        },
        
        getUserId: function () {
            return userId;
        },
        
        getUserName: function () {
            return userName || userEmail;
        },    
        
        setUserName: function(username){
            // lets make a filter for username
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
        
        setContent: function(newContent) {
            content = newContent;  
        },
        
        getContent: function () {
            return content;
        },    
        
        hasNotAllowedWords: function (searchedWord) {
            // maybe more efficient if we use foreach and return at first match
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
        },
        
        valueOf: function(){
           return {
               id: id,
                articleId: articleId,
                userId: userId,
                content: content,
                status: status,
                dateCreated: dateCreated,
                userName: userName,
                userEmail: userEmail
            };
        }

    };
    
};

Comment.prototype.STATUS_APROVED = 'APROVED';
Comment.prototype.STATUS_REJECTED = 'REJECT';
Comment.prototype.STATUS_PENDING = 'PENDING';