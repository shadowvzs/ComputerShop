var CommentList = function (commentArray) {

    var direction = "DESC";
    var comments = [];
   
    
    function initComments(listaCommentarii) {
        return listaCommentarii.map(function(commentData) {
            return new Comment(commentData);
        });
    }
    
    if (commentArray) {
        comments = initComments(commentArray);
    }

    
    return {
        
        getCommentsLength: function() {
            return comments.length;
        },
        
        getComment: function(index) {
            return comments[index];
         },
        
        getCommentById: function(id) {
            var i = 0, len = comments.length;
            for (;i < len; i++) {
                if (comments[i].getId() == id) { return comments[i]; }
            }
            return false;
        },
                
        getCommentByUser: function(userName) {
            return comments.filter(function(e) {
                return e.getUserName() === userName;
            });   
        },
        

        addComment: function(commentData) {
            if (Array.isArray(commentData)) {
             commentData.forEach(function(c) {
                comments[direction === "DESC" ? 'push' : 'unshift'](new Comment(c));
            });               
            } else {
                comments[direction === "DESC" ? 'push' : 'unshift'](new Comment(commentData));
                return comments[comments.length];
            }
        },
        
 
        deleteComment: function(index) {
            if (comments[index]) {
               comments.splice(index, 1);
            }

        },
        
        findComment: function(id){
            var i = 0, l = comments.length;
            for (;i < l; i++) {
                if (comments[i].getId() === id) {
                    return i;
                }
            }
            return false;
        },
        
        sortByDate: function(dir) {
            if (!/(ASC|DESC)/.test(dir)) { dir = "DESC"; }
            //only for because shorter
            var bool = dir === "DESC";
            direction = dir;

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
            //sort is common to both date / last x comment
            // return if falsy value
            
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
                // i added date parse because maybae user use different format
                // if incorrect date then we return false
                if (isNaN(Date.parse(date))) { return false;}
                return comments.filter(function(e) {
                    return Date.parse(e.getDateCreated()) > Date.parse(date);
                });                
            }
        }
        
    };
    
};