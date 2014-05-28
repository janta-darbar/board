var AppConstants = {
    variables: {
        boardRowCount: 15,
        boardColCount: 15,
        boardCellWidth: 30,
        boardCellHeight: 30,
        showNumberBoard: false,
        autoTilePlace: false,
        askBeforePlay: false,
        showChat: true,
        msgSize: 11,
        boardViewing: false,
        gameId: "",
        gamePid: "",
        gamePassword: "",
        gameAuthUser: "",
        gameAuthSecret: "",
        nextGameData: "",
        proUser: false,
        analyzeUser: false,
        handheldDevice: false,
        androidDevice: false,
        showGameOver: 0,
        analyzeGame: 0,
        siteNodes: ["Email", "FB"],
        siteCode: "",
        firstTime: false,
        autoRefresh: false,
        paymentSuccess: "2",
        protocol: "",
        hideAdvert: "",
        isCustomBoard: false,
        urlContactMail: "http://www.lexulous.com/sendContactMail.php",
        urlMoveMail: "http://www.lexulous.com/ajax/sendmoveemail",
        urlInnerDicSearch: "http://aws.rjs.in/fblexulous/dictionary/",
        urlOuterDicSearch: {
            "FR": "http://fr.thefreedictionary.com/",
            "IT": "http://it.thefreedictionary.com/",
            "EN": "http://www.thefreedictionary.com/"
        },
        urlPostNodes: ["http://emailgame.lexulous.com/new/gamepost/", "http://aws.rjs.in/fblexulous/engine/mob_gamepost_v11.php"],
        urlFeedNodes: ["http://emailgame.lexulous.com/new/gamefeed/", "http://aws.rjs.in/fblexulous/engine/mob_gamefeed_v11.php"],
        urlResignNodes: ["http://www.lexulous.com/email/", "https://apps.facebook.com/lexulous/"],
        urlDeleteNodes: ["http://www.lexulous.com/email/", "https://apps.facebook.com/lexulous/"],
        urlRematchNodes: ["http://www.lexulous.com/rematch", "https://apps.facebook.com/lexulous/"],
        urlNextNodes: ["http://www.lexulous.com/email/nextgame", "https://apps.facebook.com/lexulous/"],
        urlHomeNodes: ["http://www.lexulous.com/email/", "https://apps.facebook.com/lexulous/"],
        proURL: {
            next: ["http://emailgame.lexulous.com/new/emailgame/nextgame/", "http://aws.rjs.in/fblexulous/engine/mob_gamepost_v11.php"]
        },
        callURL: {
            post: "",
            feed: "",
            resign: "",
            del: "",
            rematch: "",
            next: "",
            home: "",
            analyze: "http://www.lexulous.com/lexalizer?email=1"
        },
        emoUrl: "http://dgy15uhpz7zbk.cloudfront.net/images/emoticons",
        h2hUrl: "http://aws.rjs.in/fblexulous/ajax/h2hstats.php",
        userStatURL: "https://apps.facebook.com/lexulous/?action=profile&profileid="
    },
    elmIds: {
        gameContainer: "elex_gameContainer",
        headerPanel: "elex_headerPanel",
        bodyPanel: "elex_bodyPanel",
        leftPanel: "elex_leftPanel",
        boardPanelCont: "elex_boardPanelCont",
        boardPanel: "elex_boardPanel",
        actionPanel: "elex_actionPanel",
        leftActionPanel: "elex_leftActionPanel",
        rackPanel: "elex_rackPanel",
        rightActionPanel: "elex_rightActionPanel",
        rightPanel: "elex_rightPanel",
        menuConatiner: "elex_menuContainer",
        optionMenu: "elex_optionMenu",
        playerList: "elex_playerList",
        infoPanel: "elex_infoPanel",
        combinedPanel: "elex_combinedPanel"
    },
    styleClasses: {
        gameContainer: "gameContainer",
        headerPanel: "headerPanel",
        headerPanel_yourTurn: "yourTurn",
        headerPanel_gameType: "gameType",
        bodyPanel: "bodyPanel",
        bodyPanel_leftPanel: "leftPanel",
        boardPanelCont: "boardPanelCont",
        boardPanel: "boardPanel",
        boardPanel_tileContainer: "tileContainer",
        tileContainer_rightArraw: "rightArrow",
        tileContainer_downArrow: "downArrow",
        tileContainer_starImg: "starImg",
        boardPanel_bonusText: "bonusText",
        actionPanel: "actionPanel",
        actionPanel_leftActionPanel: "leftActionPanel",
        actionPanel_rightActionPanel: "rightActionPanel",
        actionPanel_greyButton: "greyButton",
        rackPanel: "rackPanel",
        rackPanel_score: "tempScore",
        tileRack: "tileRack",
        tileRackKey: "tileRackKey",
        tileLastPlayed: "tileLastPlayed",
        tileLastPlayedKey: "tileLastPlayedKey",
        tilePlayed: "tilePlayed",
        tilePlayedKey: "tilePlayedKey",
        tileValue: "tileValue",
        bodyPanel_rightPanel: "rightPanel",
        rightPanel_optionMenu: "optionMenu",
        optionMenu_over: "optionMenuOver",
        playerList: "playerList",
        playerList_userName: "userName",
        playerList_userPro: "userPro",
        playerList_userOnline: "userOnline",
        playerList_userScore: "userOnline",
        playerList_userScore: "userScore",
        playerList_turnArrow: "turnArrow",
        playerList_userNameTurn: "userNameTurn",
        playerList_userNotPro: "userNotPro",
        playerList_userScoreTurn: "userScoreTurn",
        infoPanel: "infoPanel",
        infoPanel_playWord: "playWord",
        infoPanel_tilesLeft: "tilesLeft",
        infoPanel_challengeLink: "challengeLink",
        combinedPanel: "combinedPanel",
        combinedPanel_heading: "heading",
        combinedPanel_body: "body",
        heading_menuActive: "menuActive",
        heading_menuInactive: "menuInactive",
        userInPanel_body: "body",
        dicPanel: "dicPanel",
        dicPanel_dicSlot: "dicSlot",
        dicPanel_dicInput: "dicInput",
        dicPanel_dicInputBox: "dicInputBox",
        dicPanel_sendButton: "sendButton",
        dicPanel_wordCheck: "wordCheck",
        dicPanel_footer: "footer",
        chatPanel: "chatPanel",
        chatPanel_chatBody: "chatBody",
        chatPanel_opponentChatIcon1: "opponentChatIcon1",
        chatPanel_opponentChatIcon2: "opponentChatIcon2",
        chatPanel_opponentChatIcon3: "opponentChatIcon3",
        chatPanel_chatInput: "chatInput",
        chatPanel_inputBox: "inputBox",
        chatPanel_sendButton: "sendButton",
        chatPanel_senderName: "senderName",
        chatPanel_chatDate: "chatDate",
        activityOver: "activityOver",
        activityLoader: "activityLoader",
        popUp: "popUp",
        popUp_contain: "contain",
        popUp_header: "header",
        popUp_body: "body",
        popUp_footer: "footer",
        popUp_redButton: "redButton",
        popUp_blueButton: "blueButton",
        contextMenu: "contextMenu",
        blankTilePopup: "blankTilePopup",
        feedbackTextArea: "feedbackTextArea"
    }
};
var AppController = {
    init: function (obj) {
        if (navigator.userAgent.match(/Android/i) || navigator.userAgent.match(/webOS/i) || navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPod/i) || navigator.userAgent.match(/iPad/i) || navigator.userAgent.match(/BlackBerry/) || navigator.userAgent.match(/PlayBook/i)) {
            AppConstants.variables.handheldDevice = true;
        }
        if (navigator.userAgent.match(/Android/i)) {
            AppConstants.variables.androidDevice = true;
        }
        AppConstants.variables.gameId = obj.gid;
        AppConstants.variables.gamePid = obj.pid;
        AppConstants.variables.gamePassword = obj.password;
        AppConstants.variables.gameAuthUser = obj.authuser;
        AppConstants.variables.gameAuthSecret = obj.authsecret;
        AppConstants.variables.showNumberBoard = obj.showNumberBoard;
        AppConstants.variables.autoTilePlace = obj.autoTilePlace;
        AppConstants.variables.askBeforePlay = (obj.askBeforePlay == "y") ? true : false;
        AppConstants.variables.msgSize = obj.msgSize;
        AppConstants.variables.autoRefresh = obj.autoRefresh;
        AppConstants.variables.siteCode = AppConstants.variables.siteNodes[obj.sitecode];
        AppConstants.variables.callURL.post = AppConstants.variables.urlPostNodes[obj.sitecode];
        AppConstants.variables.callURL.feed = AppConstants.variables.urlFeedNodes[obj.sitecode];
        AppConstants.variables.callURL.resign = AppConstants.variables.urlResignNodes[obj.sitecode];
        AppConstants.variables.callURL.del = AppConstants.variables.urlDeleteNodes[obj.sitecode];
        AppConstants.variables.callURL.next = AppConstants.variables.urlNextNodes[obj.sitecode];
        AppConstants.variables.callURL.rematch = AppConstants.variables.urlRematchNodes[obj.sitecode];
        AppConstants.variables.callURL.home = AppConstants.variables.urlHomeNodes[obj.sitecode];
        AppConstants.variables.nextGameData = {
            gid: obj.nextGame.split(",")[0],
            pid: obj.nextGame.split(",")[1],
            lang: obj.nextGame.split(",")[2]
        };
        AppConstants.variables.firstTime = obj.firstTime;
        AppConstants.variables.showGameOver = obj.showGameOver;
        AppConstants.variables.analyzeUser = obj.analyzeUser;
        AppConstants.variables.paymentSuccess = obj.paymentSuccess;
        AppConstants.variables.protocol = obj.protocol;
        AppConstants.variables.hideAdvert = obj.hideAdvert;
        AppConstants.variables.boardViewing = obj.boardViewing;
        GameController.preLoad();
    }
};
var InstaController = {
    init: function () {
        WEB_SOCKET_DEBUG = true;
        var pusher = new Pusher("7678338387b361dd06a2");
        var channel = pusher.subscribe("LexComEmailGame_" + AppConstants.variables.gameId);
        channel.bind("gamePostAction_Success", InstaController.doAction);
    },
    doAction: function (data) {
        if (String(data.playedPid) == String(AppConstants.variables.gamePid)) {
            return;
        }
        GameController.reload();
    }
};
var SoundController = {
    loaded: false,
    type: {
        mouseDown: "MOUSEDOWN",
        poing: "POING"
    },
    init: function () {
        var agent = navigator.userAgent.toLowerCase();
        var fileType = "";
        if (agent.indexOf("chrome") > -1) {
            fileType = ".mp3";
        } else {
            if (agent.indexOf("opera") > -1) {
                fileType = ".ogg";
            } else {
                if (agent.indexOf("firefox") > -1) {
                    fileType = ".ogg";
                } else {
                    if (agent.indexOf("safari") > -1) {
                        fileType = ".mp3";
                    } else {
                        if (agent.indexOf("msie") > -1) {
                            fileType = ".mp3";
                        }
                    }
                }
            }
        }
        SoundJS.onLoadQueueComplete = SoundController.afterLoad();
        SoundJS.addBatch({
            name: "MOUSEDOWN",
            src: "sound/mousedown" + fileType,
            instances: 1
        }, {
            name: "POING",
            src: "sound/poing" + fileType,
            instances: 1
        });
    },
    afterLoad: function () {
        SoundController.loaded = true;
    },
    play: function (type) {
        if (!SoundController.loaded) {
            return;
        }
        switch (type) {
        case "MOUSEDOWN":
        case "POING":
            SoundJS.play(type, SoundJS.INTERUPT_NONE);
            break;
        }
    }
};
var RequestController = {
    callbackObj: null,
    loadFeed: function () {
        var rqStr = "";
        if (AppConstants.variables.siteCode == "Email") {
            rqStr += 'json={"authuser":"' + AppConstants.variables.gameAuthUser + '","authsecret":"' + AppConstants.variables.gameAuthSecret + '","gid":"' + AppConstants.variables.gameId + '","pid":"' + AppConstants.variables.gamePid + '","passencode":"y"}';
        } else {
            if (AppConstants.variables.siteCode == "FB") {
                obj = {
                    fb_sig_user: AppConstants.variables.gameAuthUser,
                    fb_sig_session_key: AppConstants.variables.gameAuthSecret,
                    gid: AppConstants.variables.gameId,
                    pid: AppConstants.variables.gamePid,
                    password: AppConstants.variables.gamePassword,
                    action:action,
                    showGameOver:AppConstants.variables.showGameOver,
                    mobileRequest:mobileRequest
                };
                if (AppConstants.variables.showGameOver == 1) {
                    obj.showGameOver = 1;
                }
                rqStr += "json=" + JSON.stringify(obj);
            }
        }
        ActivityIndicator.show("Loading game, ");
        AppConstants.variables.boardViewing = false;
        this.send({
            url: AppConstants.variables.callURL.feed,
            data: rqStr,
            onSuccess: function (data, textStatus) {
                FeedDataModel.init(data);
                GameController.load();
                GameController.start();
                ActivityIndicator.hide();
                if ((data.gameinfo.status == "F") && (data.gameinfo.playersNo == 2)) {
                    var gameOverList = {};
                    var txt = "";
                    if (AppConstants.variables.gamePid == 1) {
                        gameOverList.myScore = data.gameinfo.p1score;
                        gameOverList.oppScore = data.gameinfo.p2score;
                        gameOverList.oppName = data.gameinfo.p2;
                        gameOverList.psbMove = data.gameinfo.p1PossibleMove;
                        gameOverList.psbMoveGiven = data.gameinfo.p1PossibleMoveGiven;
                    } else {
                        if (AppConstants.variables.gamePid == 2) {
                            gameOverList.myScore = data.gameinfo.p2score;
                            gameOverList.oppScore = data.gameinfo.p1score;
                            gameOverList.oppName = data.gameinfo.p1;
                            gameOverList.psbMove = data.gameinfo.p2PossibleMove;
                            gameOverList.psbMoveGiven = data.gameinfo.p2PossibleMoveGiven;
                        }
                    }
                    if (PlayersModel.getInfoByPid(AppConstants.variables.gamePid)["name"] == data.gameinfo.winner) {
                        gameOverList.txt = "won";
                    } else {
                        if (data.gameinfo.winner == -1) {
                            gameOverList.txt = "draw";
                        } else {
                            gameOverList.txt = "lost";
                        }
                    }
                    if (AppConstants.variables.paymentSuccess == "2") {
                        GameOverPopup.open(gameOverList);
                    } else {
                        if (AppConstants.variables.paymentSuccess == "1") {
                            CombinedPanel.analyze();
                        }
                    }
                }
                if (typeof head2headStat != "undefined") {
                    head2headStat.get(AppConstants.variables.gamePid, GameInfoModel.dic.toLowerCase(), GameInfoModel.gameType, FeedDataModel.playersInfo, AppConstants.variables.gameId, AppConstants.variables.gamePid, AppConstants.variables.gamePassword);
                }
                if (typeof drawProgressGraph == "function" && AppConstants.variables.siteCode == "Email") {
                    drawProgressGraph(FeedDataModel.movesInfo, FeedDataModel.playersInfo);
                }
            }
        });
    },
    postMuteChat: function (obj) {
        var rqStr = "";
        if (AppConstants.variables.siteCode == "Email") {
            rqStr += 'json={"authuser":"' + AppConstants.variables.gameAuthUser + '","authsecret":"' + AppConstants.variables.gameAuthSecret + '","gid":"' + AppConstants.variables.gameId + '","pid":"' + AppConstants.variables.gamePid + '","passencode":"y"}';
        } else {
            if (AppConstants.variables.siteCode == "FB") {
                rqStr += 'json={"action":"MESSAGE","fb_sig_user":"' + AppConstants.variables.gameAuthUser + '","fb_sig_session_key":"' + AppConstants.variables.gameAuthSecret + '","gid":"' + AppConstants.variables.gameId + '","pid":"' + AppConstants.variables.gamePid + '","password":"' + AppConstants.variables.gamePassword + '","message":"' + Base64.encode(msgText) + '"}';
            }
        }
        this.send({
            url: AppConstants.variables.callURL.post + "mutechat/",
            data: rqStr,
            onSuccess: function (data, textStatus) {}
        });
    },
    postContactMail: function (obj) {
        var rqStr = "userText=" + Base64.encode(obj.userText) + "&bugText=" + Base64.encode(obj.bugText);
        ActivityIndicator.show("Sending message, ");
        this.send({
            url: AppConstants.variables.urlContactMail,
            data: rqStr,
            onSuccess: function (data, textStatus) {
                ActivityIndicator.hide();
                GameController.getResponse(data);
            }
        });
    },
    postMoveMail: function (obj) {
        this.send({
            url: AppConstants.variables.urlMoveMail + "?json=" + JSON.stringify(obj),
            onSuccess: function (data, textStatus) {}
        });
    },
    postHome: function () {
        ActivityIndicator.show("Loading, ");
        window.location.href = AppConstants.variables.callURL.home;
    },
    postRematch: function () {
        var rqStr = "";
        if (AppConstants.variables.siteCode == "Email") {
            rqStr += "?gid=" + AppConstants.variables.gameId;
        } else {
            if (AppConstants.variables.siteCode == "FB") {
                var oppUids = [];
                for (var index = 1; index <= PlayersModel.getPlayersCount(); index++) {
                    if (PlayersModel.getUidByPid(index) != PlayersModel.getMyUid()) {
                        oppUids.push(PlayersModel.getUidByPid(index));
                    }
                }
                var myid = PlayersModel.getMyUid();
                var myInfo = PlayersModel.getInfoByUid(myid);
                var name = [];
                for (var i = 0; i < PlayersModel.getPlayersCount(); i++) {
                    if (PlayersModel.playersInfo["_" + PlayersModel.playersUid[i]].name != myInfo.name) {
                        name.push(PlayersModel.playersInfo["_" + PlayersModel.playersUid[i]].name);
                    }
                }
                name = name.join(",");
                rqStr += "?action=rematch&with=" + oppUids.join(",") + "&name=" + name + "&rematch=1&game_id=" + AppConstants.variables.gameId;
            }
        }
        ActivityIndicator.show("Loading, ");
        top.location.href = AppConstants.variables.callURL.rematch + rqStr;
    },
    postNextGame: function () {
        ActivityIndicator.show("Loading, ");
        var rqStr = "";
        if (GameInfoModel.isProUser(PlayersModel.getUidByPid(AppConstants.variables.gamePid))) {
            if (AppConstants.variables.siteCode == "Email") {
                rqStr += 'json={"authuser":"' + AppConstants.variables.gameAuthUser + '","authsecret":"' + AppConstants.variables.gameAuthSecret + '","gid":"' + AppConstants.variables.gameId + '","passencode":"y"}';
            } else {
                if (AppConstants.variables.siteCode == "FB") {
                    rqStr += 'json={"action":"NEXTGAME","fb_sig_user":"' + AppConstants.variables.gameAuthUser + '","fb_sig_session_key":"' + AppConstants.variables.gameAuthSecret + '","gid":"' + AppConstants.variables.gameId + '","pid":"' + AppConstants.variables.gamePid + '","password":"' + AppConstants.variables.gamePassword + '"}';
                }
            }
            this.send({
                url: ((AppConstants.variables.siteCode == "Email") ? AppConstants.variables.proURL.next[0] : AppConstants.variables.proURL.next[1]),
                data: rqStr,
                onSuccess: function (data, textStatus) {
                    ActivityIndicator.hide();
                    GameController.getResponse(data);
                }
            });
        } else {
            var purl = "";
            if (AppConstants.variables.siteCode == "Email") {
                purl = AppConstants.variables.callURL.next + "?gid=" + AppConstants.variables.gameId;
                window.location.href = purl;
            } else {
                if (AppConstants.variables.siteCode == "FB") {
                    purl = AppConstants.variables.callURL.rematch += "?action=jump&skipgid=" + AppConstants.variables.gameId;
                    top.location.href = purl;
                }
            }
        }
    },
    postResign: function () {
        var rqStr = "";
        if (AppConstants.variables.siteCode == "Email") {
            rqStr += 'json={"authuser":"' + AppConstants.variables.gameAuthUser + '","authsecret":"' + AppConstants.variables.gameAuthSecret + '","gid":"' + AppConstants.variables.gameId + '","pid":"' + AppConstants.variables.gamePid + '","passencode":"y"}';
        } else {
            if (AppConstants.variables.siteCode == "FB") {
                rqStr += 'json={"action":"RESIGN","fb_sig_user":"' + AppConstants.variables.gameAuthUser + '","fb_sig_session_key":"' + AppConstants.variables.gameAuthSecret + '","gid":"' + AppConstants.variables.gameId + '","pid":"' + AppConstants.variables.gamePid + '","password":"' + AppConstants.variables.gamePassword + '"}';
            }
        }
        ActivityIndicator.show("Loading, ");
        this.send({
            url: AppConstants.variables.callURL.post + ((AppConstants.variables.siteCode == "Email") ? "resign/" : ""),
            data: rqStr,
            onSuccess: function (data, textStatus) {
                ActivityIndicator.hide();
                GameController.getResponse(data);
            }
        });
    },
    postDelete: function () {
        var rqStr = "";
        if (AppConstants.variables.siteCode == "Email") {
            rqStr += 'json={"authuser":"' + AppConstants.variables.gameAuthUser + '","authsecret":"' + AppConstants.variables.gameAuthSecret + '","gid":"' + AppConstants.variables.gameId + '","pid":"' + AppConstants.variables.gamePid + '","passencode":"y"}';
        } else {
            if (AppConstants.variables.siteCode == "FB") {
                rqStr += 'json={"action":"DELETE","fb_sig_user":"' + AppConstants.variables.gameAuthUser + '","fb_sig_session_key":"' + AppConstants.variables.gameAuthSecret + '","gid":"' + AppConstants.variables.gameId + '","pid":"' + AppConstants.variables.gamePid + '","password":"' + AppConstants.variables.gamePassword + '"}';
            }
        }
        ActivityIndicator.show("Loading, ");
        this.send({
            url: AppConstants.variables.callURL.post + ((AppConstants.variables.siteCode == "Email") ? "delete/" : ""),
            data: rqStr,
            onSuccess: function (data, textStatus) {
                ActivityIndicator.hide();
                GameController.getResponse(data);
            }
        });
    },
    postChallenge: function () {
        var rqStr = "";
        if (AppConstants.variables.siteCode == "Email") {
            rqStr += 'json={"authuser":"' + AppConstants.variables.gameAuthUser + '","authsecret":"' + AppConstants.variables.gameAuthSecret + '","gid":"' + AppConstants.variables.gameId + '","pid":"' + AppConstants.variables.gamePid + '","passencode":"y"}';
        } else {
            if (AppConstants.variables.siteCode == "FB") {
                rqStr += 'json={"action":"CHALLENGE","fb_sig_user":"' + AppConstants.variables.gameAuthUser + '","fb_sig_session_key":"' + AppConstants.variables.gameAuthSecret + '","gid":"' + AppConstants.variables.gameId + '","pid":"' + AppConstants.variables.gamePid + '","password":"' + AppConstants.variables.gamePassword + '","notify_fb":"y"}';
            }
        }
        ActivityIndicator.show("Challenging move, ");
        this.send({
            url: AppConstants.variables.callURL.post + ((AppConstants.variables.siteCode == "Email") ? "challenge/" : ""),
            data: rqStr,
            onSuccess: function (data, textStatus) {
                ActivityIndicator.hide();
                GameController.getResponse(data);
            }
        });
    },
    postDicCheck: function (dicObj) {
        var rqStr = "word=" + dicObj.searchText + "&dic=" + dicObj.dicType + "&mode=JSONP";
        ActivityIndicator.show("Checking word, ");
        this.send({
            url: AppConstants.variables.urlInnerDicSearch,
            data: rqStr,
            onSuccess: function (data, textStatus) {
                ActivityIndicator.hide();
                GameController.getResponse(data);
            }
        });
    },
    postSwap: function (swapText) {
        var rqStr = "";
        if (AppConstants.variables.siteCode == "Email") {
            rqStr += 'json={"authuser":"' + AppConstants.variables.gameAuthUser + '","authsecret":"' + AppConstants.variables.gameAuthSecret + '","gid":"' + AppConstants.variables.gameId + '","pid":"' + AppConstants.variables.gamePid + '","str":"' + swapText + '","passencode":"y"}';
        } else {
            if (AppConstants.variables.siteCode == "FB") {
                rqStr += 'json={"action":"SWAP","fb_sig_user":"' + AppConstants.variables.gameAuthUser + '","fb_sig_session_key":"' + AppConstants.variables.gameAuthSecret + '","gid":"' + AppConstants.variables.gameId + '","pid":"' + AppConstants.variables.gamePid + '","password":"' + AppConstants.variables.gamePassword + '","str":"' + swapText + '","notify_fb":"y"}';
            }
        }
        ActivityIndicator.show("Exchanging tiles, ");
        this.send({
            url: AppConstants.variables.callURL.post + ((AppConstants.variables.siteCode == "Email") ? "swap/" : ""),
            data: rqStr,
            onSuccess: function (data, textStatus) {
                ActivityIndicator.hide();
                GameController.getResponse(data);
                if (typeof drawProgressGraph == "function") {
                    drawProgressGraph(FeedDataModel.movesInfo, FeedDataModel.playersInfo);
                }
            }
        });
    },
    postMove: function (moveObj) {
        var rqStr = "";
        var moveArr = [];
        for (var index = 0; index < moveObj.length; index++) {
            moveArr.push(moveObj[index].chr + "," + moveObj[index].y + "," + moveObj[index].x + ",n");
        }
        if (AppConstants.variables.siteCode == "Email") {
            rqStr += 'json={"authuser":"' + AppConstants.variables.gameAuthUser + '","authsecret":"' + AppConstants.variables.gameAuthSecret + '","gid":"' + AppConstants.variables.gameId + '","pid":"' + AppConstants.variables.gamePid + '","txt":"' + moveArr.join(",") + '","passencode":"y"}';
        } else {
            if (AppConstants.variables.siteCode == "FB") {
                rqStr += 'json={"action":"MOVE","fb_sig_user":"' + AppConstants.variables.gameAuthUser + '","fb_sig_session_key":"' + AppConstants.variables.gameAuthSecret + '","gid":"' + AppConstants.variables.gameId + '","pid":"' + AppConstants.variables.gamePid + '","password":"' + AppConstants.variables.gamePassword + '","txt":"' + moveArr.join(",") + '","notify_fb":"y"}';
            }
        }
        ActivityIndicator.show("Sending move, ");
        this.send({
            url: AppConstants.variables.callURL.post + ((AppConstants.variables.siteCode == "Email") ? "move/" : ""),
            data: rqStr,
            onSuccess: function (data, textStatus) {
                data["moveObj"] = moveObj;
                ActivityIndicator.hide();
                GameController.getResponse(data);
                if (typeof drawProgressGraph == "function") {
                    drawProgressGraph(FeedDataModel.movesInfo, FeedDataModel.playersInfo);
                }
            }
        });
    },
    postMessage: function (msgText) {
        var rqStr = "";
        if (AppConstants.variables.siteCode == "Email") {
            rqStr += 'json={"authuser":"' + AppConstants.variables.gameAuthUser + '","authsecret":"' + AppConstants.variables.gameAuthSecret + '","gid":"' + AppConstants.variables.gameId + '","pid":"' + AppConstants.variables.gamePid + '","message":"' + Base64.encode(msgText) + '","passencode":"y"}';
        } else {
            if (AppConstants.variables.siteCode == "FB") {
                rqStr += 'json={"action":"MESSAGE","fb_sig_user":"' + AppConstants.variables.gameAuthUser + '","fb_sig_session_key":"' + AppConstants.variables.gameAuthSecret + '","gid":"' + AppConstants.variables.gameId + '","pid":"' + AppConstants.variables.gamePid + '","password":"' + AppConstants.variables.gamePassword + '","message":"' + Base64.encode(msgText) + '","encrypted":"y","notify_fb":"y"}';
            }
        }
        ActivityIndicator.show("Sending message, ");
        this.send({
            url: AppConstants.variables.callURL.post + ((AppConstants.variables.siteCode == "Email") ? "message/" : ""),
            data: rqStr,
            onSuccess: function (data, textStatus) {
                data["msg"] = msgText;
                ActivityIndicator.hide();
                GameController.getResponse(data);
            }
        });
    },
    postPass: function () {
        var rqStr = "";
        if (AppConstants.variables.siteCode == "Email") {
            rqStr += 'json={"authuser":"' + AppConstants.variables.gameAuthUser + '","authsecret":"' + AppConstants.variables.gameAuthSecret + '","gid":"' + AppConstants.variables.gameId + '","pid":"' + AppConstants.variables.gamePid + '","passencode":"y"}';
        } else {
            if (AppConstants.variables.siteCode == "FB") {
                rqStr += 'json={"action":"PASS","fb_sig_user":"' + AppConstants.variables.gameAuthUser + '","fb_sig_session_key":"' + AppConstants.variables.gameAuthSecret + '","gid":"' + AppConstants.variables.gameId + '","pid":"' + AppConstants.variables.gamePid + '","password":"' + AppConstants.variables.gamePassword + '","notify_fb":"y"}';
            }
        }
        ActivityIndicator.show("Passing turn, ");
        this.send({
            url: AppConstants.variables.callURL.post + ((AppConstants.variables.siteCode == "Email") ? "pass/" : ""),
            data: rqStr,
            onSuccess: function (data, textStatus) {
                ActivityIndicator.hide();
                GameController.getResponse(data);
                if (typeof drawProgressGraph == "function") {
                    drawProgressGraph(FeedDataModel.movesInfo, FeedDataModel.playersInfo);
                }
            }
        });
    },
    postStat: function (statUid, name) {
        var rqStr = "";
        if (AppConstants.variables.siteCode == "Email") {
            rqStr += 'json={"authuser":"' + AppConstants.variables.gameAuthUser + '","authsecret":"' + AppConstants.variables.gameAuthSecret + '","statuid":"' + statUid + '","passencode":"y"}';
        } else {
            if (AppConstants.variables.siteCode == "FB") {}
        }
        ActivityIndicator.show("Loading, ");
        this.send({
            url: "http://emailgame.lexulous.com/new/emailgame/stats",
            data: rqStr,
            onSuccess: function (data, textStatus) {
                data.name = name;
                data.uid = statUid;
                ActivityIndicator.hide();
                data.action = "USERSTAT";
                GameController.getResponse(data);
            }
        });
    },
    send: function (obj) {
        if (AppConstants.variables.siteCode == "FB" && window.location.protocol == "https:") {
            obj.url = obj.url.replace("http:", "https:");
        }
        obj.data += "&notify_fb=y";
        this.callbackObj = obj;
        FeedBackPanel.add(obj.url + "->" + obj.data);
        $.ajax({
            url: obj.url,
            data: obj.data,
            dataType: "jsonp",
            jsonp: "callback",
            jsonpCallback: "RequestController.callbackObj.onSuccess"
        });
    }
};
var GameController = {
    isReloading: false,
    postRequestType: {
        diccheck: "DICCHECK",
        message: "MESSAGE",
        pass: "PASS",
        move: "MOVE",
        swap: "SWAP",
        refresh: "REFRESH",
        challenge: "CHALLENGE",
        resignGame: "RESIGN",
        deleteGame: "DELETE",
        rematch: "REMATCH",
        nextGame: "NEXTGAME",
        home: "HOME",
        contactMail: "CONTACTMAIL"
    },
    preLoad: function () {
        $("#elex_temp_loader").hide();
        RequestController.loadFeed();
    },
    load: function () {
        GameInfoModel.init(FeedDataModel.gameInfo);
        PlayersModel.init({
            playersUid: FeedDataModel.playersUid,
            playersInfo: FeedDataModel.playersInfo
        });
        MovesModel.init({
            movesInfo: FeedDataModel.movesInfo
        });
        // TileModel.init();
        TileModel.init({ tileString : FeedDataModel.tileString });
        BoardModel.init({
            nodeString: FeedDataModel.nodeString
        });
        RackModel.init();
        ChatModel.init({
            messageInfo: FeedDataModel.messagesInfo
        });
    },
    start: function () {
        if (this.isReloading) {
            Canvas.redraw();
            this.isReloading = false;
        } else {
            Canvas.draw();
        }
    },
    reload: function () {
        this.isReloading = true;
        this.preLoad();
    },
    postRequest: function (obj) {
        switch (obj.action) {
        case "MUTECHAT":
            RequestController.postMuteChat(obj);
            break;
        case "USERSTAT":
            RequestController.postStat(obj.statUid, obj.name);
            break;
        case "CONTACTMAIL":
            RequestController.postContactMail(obj.mail);
            break;
        case "HOME":
            RequestController.postHome();
            break;
        case "REMATCH":
            RequestController.postRematch();
            break;
        case "NEXTGAME":
            RequestController.postNextGame();
            break;
        case "CHALLENGE":
            RequestController.postChallenge();
            break;
        case "DICCHECK":
            RequestController.postDicCheck(obj.dicObj);
            break;
        case "REFRESH":
            this.reload();
            break;
        case "SWAP":
            RequestController.postSwap(obj.swapText);
            break;
        case "MOVE":
            RequestController.postMove(obj.moveObj);
            break;
        case "MESSAGE":
            RequestController.postMessage(obj.message);
            break;
        case "PASS":
            RequestController.postPass();
            break;
        case "RESIGN":
            RequestController.postResign();
            break;
        case "DELETE":
            RequestController.postDelete();
            break;
        }
    },
    getResponse: function (data) {
        switch (data.action) {
        case "USERSTAT":
            StatModel.setData(data.uid, data);
            StatPanel.draw(data);
            break;
        case "CONTACTMAIL":
            if (data.check == "Success") {}
            break;
        case "NEXTGAME":
            if (data.check == "Failure") {
                ActivityIndicator.show(data.message, true);
                $(document).trigger("lexGameboardNextFailure", []);
            } else {
                if (data.gid != "" && data.pid != "" && AppConstants.variables.siteCode == "Email") {
                    AppConstants.variables.gameId = data.gid;
                    AppConstants.variables.gamePid = data.pid;
                    this.reload();
                } else {
                    if (data.gid != "" && data.pid != "" && data.password && AppConstants.variables.siteCode == "FB") {
                        AppConstants.variables.gameId = data.gid;
                        AppConstants.variables.gamePid = data.pid;
                        AppConstants.variables.gamePassword = data.password;
                        this.reload();
                    } else {
                        ActivityIndicator.show("Loading, ");
                        top.location.href = AppConstants.variables.callURL.home;
                    }
                }
                $(document).trigger("lexGameboardNextSuccess", []);
            }
            break;
        case "DELETE":
            if (data.check == "Failure") {
                ActivityIndicator.show(data.message, true);
                $(document).trigger("lexGameboardDeleteFailure", []);
            } else {
                top.location.href = AppConstants.variables.callURL.del;
                $(document).trigger("lexGameboardDeleteSuccess", []);
            }
            break;
        case "RESIGN":
            if (data.check == "Failure") {
                ActivityIndicator.show(data.message, true);
                $(document).trigger("lexGameboardResignFailure", []);
            } else {
                top.location.href = AppConstants.variables.callURL.resign;
                $(document).trigger("lexGameboardResignSuccess", []);
            }
            break;
        case "CHALLENGE":
            if (data.check == "Failure") {
                ActivityIndicator.show(data.message, true);
                this.reload();
                $(document).trigger("lexGameboardChallengeFailure", []);
            } else {
                this.reload();
                $(document).trigger("lexGameboardChallengeSuccess", []);
            }
            break;
        case "DICCHECK":
            if (data.check == "Failure") {
                ActivityIndicator.show(data.message, true);
            } else {
                if (data.status == "valid") {
                    DicPanel.updateWordCheckResult(true, data.message);
                } else {
                    DicPanel.updateWordCheckResult(false, data.message);
                }
            }
            break;
        case "SWAP":
            if (data.check == "Failure") {
                ActivityIndicator.show(data.message, true);
                $(document).trigger("lexGameboardSwapFailure", []);
            } else {
                GameInfoModel.assign({
                    myRack: data.newRack,
                    myTurn: false,
                    turnUid: PlayersModel.getUidByPid(data.currentMove)
                });
                MovesModel.update({
                    uid: PlayersModel.getMyUid(),
                    word: "",
                    score: "0",
                    moveType: "SWAP"
                });
                RackModel.init();
                Canvas.redraw();
                ActionPanel.change(ActionPanel.type.NOTURN);
                if (AppConstants.variables.firstTime) {
                    Tutorial.show(9);
                    AppConstants.variables.firstTime = false;
                }
                $(document).trigger("lexGameboardSwapSuccess", []);
            }
            break;
        case "MOVE":
            if (data.check == "Failure") {
                if (data.wrong_word != undefined) {
                    ActivityIndicator.show(data.wrong_word + " is an invalid word.", true);
                } else {
                    ActivityIndicator.show(data.message, true);
                }
                $(document).trigger("lexGameboardMoveFailure", []);
            } else {
                if (data.gameOver == "0") {
                    GameInfoModel.assign({
                        myRack: data.newRack,
                        myTurn: false,
                        turnUid: PlayersModel.getUidByPid(data.currentMove),
                        winner: data.winner
                    });
                    MovesModel.update({
                        uid: PlayersModel.getMyUid(),
                        word: data.wordPlayed,
                        score: data.score,
                        moveType: "MOVE"
                    });
                    PlayersModel.updateMyScore(data.score);
                    BoardModel.update(data.moveObj);
                    RackModel.init();
                    Canvas.redraw();
                    ActionPanel.change(ActionPanel.type.NOTURN);
                    if (AppConstants.variables.firstTime) {
                        Tutorial.show(9);
                        AppConstants.variables.firstTime = false;
                    }
                } else {
                    if (data.gameOver == "1") {
                        var winner = "";
                        if (data.winner != -1) {
                            winner = PlayersModel.getInfoByPid(data.winner)["name"];
                        } else {
                            winner = data.winner;
                        }
                        var gameOverList = {};
                        var txt = "";
                        if (AppConstants.variables.gamePid == 1) {
                            gameOverList.myScore = data.p1score;
                            gameOverList.oppScore = data.p2score;
                            gameOverList.oppName = PlayersModel.getInfoByPid("2")["name"];
                            gameOverList.psbMove = data.p1PossibleMove;
                            gameOverList.psbMoveGiven = data.p1PossibleMoveGiven;
                        } else {
                            if (AppConstants.variables.gamePid == 2) {
                                gameOverList.myScore = data.p2score;
                                gameOverList.oppScore = data.p1score;
                                gameOverList.oppName = PlayersModel.getInfoByPid("1")["name"];
                                gameOverList.psbMove = data.p2PossibleMove;
                                gameOverList.psbMoveGiven = data.p2PossibleMoveGiven;
                            }
                        }
                        if (AppConstants.variables.gamePid == data.winner) {
                            gameOverList.txt = "won";
                        } else {
                            if (data.winner == -1) {
                                gameOverList.txt = "draw";
                            } else {
                                gameOverList.txt = "lost";
                            }
                        }
                        GameInfoModel.assign({
                            myRack: "",
                            myTurn: false,
                            turnUid: 0,
                            winner: winner,
                            status: "F"
                        });
                        MovesModel.update({
                            uid: PlayersModel.getMyUid(),
                            word: data.wordPlayed,
                            score: data.score,
                            moveType: "MOVE"
                        });
                        PlayersModel.updateGameOver(data.p1score, data.p2score, data.p3score, data.p4score);
                        BoardModel.update(data.moveObj);
                        RackModel.init();
                        Canvas.redraw();
                        ActionPanel.change(ActionPanel.type.GAME_OVER);
                        if (PlayersModel.getPlayersCount() == 2) {
                            GameOverPopup.open(gameOverList);
                        }
                    }
                }
                $(document).trigger("lexGameboardMoveSuccess", []);
            }
            break;
        case "MESSAGE":
            if (data.check == "Failure") {
                ActivityIndicator.show(data.message, true);
                $(document).trigger("lexGameboardMessageFailure", []);
            } else {
                var obj = {
                    uid: PlayersModel.getUidByPid(AppConstants.variables.gamePid),
                    date: ChatPanel.getServerDate(),
                    msg: data.msg
                };
                ChatModel.setData(obj);
                ChatPanel.addChatMsg(obj);
                ChatPanel.scrollToBottom();
                $(document).trigger("lexGameboardMessageSuccess", [obj]);
            }
            break;
        case "PASS":
            if (data.check == "Failure") {
                ActivityIndicator.show(data.message, true);
                $(document).trigger("lexGameboardPassFailure", []);
            } else {
                if (data.gameOver == "0") {
                    MovesModel.update({
                        uid: PlayersModel.getMyUid(),
                        word: "",
                        score: "0",
                        moveType: "PASS"
                    });
                    GameInfoModel.assign({
                        myTurn: false,
                        turnUid: PlayersModel.getUidByPid(data.currentMove)
                    });
                    Canvas.redraw();
                    ActionPanel.change(ActionPanel.type.NOTURN);
                    if (AppConstants.variables.firstTime) {
                        Tutorial.show(9);
                        AppConstants.variables.firstTime = false;
                    }
                } else {
                    if (data.gameOver == "1") {
                        var winner = "";
                        if (data.winner != -1) {
                            winner = PlayersModel.getInfoByPid(data.winner)["name"];
                        } else {
                            winner = data.winner;
                        }
                        var gameOverList = {};
                        var txt = "";
                        if (AppConstants.variables.gamePid == 1) {
                            gameOverList.myScore = data.p1score;
                            gameOverList.oppScore = data.p2score;
                            gameOverList.oppName = PlayersModel.getInfoByPid("2")["name"];
                            gameOverList.psbMove = data.p1PossibleMove;
                            gameOverList.psbMoveGiven = data.p1PossibleMoveGiven;
                        } else {
                            if (AppConstants.variables.gamePid == 2) {
                                gameOverList.myScore = data.p2score;
                                gameOverList.oppScore = data.p1score;
                                gameOverList.oppName = PlayersModel.getInfoByPid("1")["name"];
                                gameOverList.psbMove = data.p2PossibleMove;
                                gameOverList.psbMoveGiven = data.p2PossibleMoveGiven;
                            }
                        }
                        if (AppConstants.variables.gamePid == data.winner) {
                            gameOverList.txt = "won";
                        } else {
                            if (data.winner == -1) {
                                gameOverList.txt = "draw";
                            } else {
                                gameOverList.txt = "lost";
                            }
                        }
                        MovesModel.update({
                            uid: PlayersModel.getMyUid(),
                            word: "",
                            score: "0",
                            moveType: "PASS"
                        });
                        PlayersModel.updateGameOver(data.p1score, data.p2score, data.p3score, data.p4score);
                        GameInfoModel.assign({
                            myTurn: false,
                            turnUid: 0,
                            winner: winner,
                            status: "F"
                        });
                        Canvas.redraw();
                        ActionPanel.change(ActionPanel.type.GAME_OVER);
                        if (PlayersModel.getPlayersCount() == 2) {
                            GameOverPopup.open(gameOverList);
                        }
                    }
                }
                $(document).trigger("lexGameboardPassSuccess", []);
            }
            break;
        }
    }
};
var FeedDataModel = {
    playersUid: null,
    playersInfo: null,
    movesInfo: null,
    messagesInfo: null,
    gameInfo: null,
    nodeString: "",
    cellWeightString: "",
    rating: {},
    msgSpecsArr: null,
    boardLayout : null,
    tileLeft : null,
    init: function (obj) {
        var pid = 1;
        var index = 0;
        var pos = 1;
        this.playersUid = new Array();
        for (index = 0, pid = 1; index < parseInt(obj.gameinfo.playersNo); index++, pid++) {
            this.playersUid[index] = obj.gameinfo["p" + parseInt(pid) + "email"];
            this.rating[pid] = obj.gameinfo["p" + parseInt(pid) + "rating"];
        }
        this.playersInfo = new Array();
        for (index = 0, pid = 1; index < parseInt(obj.gameinfo.playersNo); index++, pid++) {
            this.playersInfo["_" + this.playersUid[index]] = {
                pid: pid,
                name: obj.gameinfo["p" + pid],
                online: ((obj.gameinfo["p" + pid + "status"] == "online") ? true : false),
                score: obj.gameinfo["p" + pid + "score"],
                rackLength: obj.gameinfo["p" + pid + "racklen"]
            };
        }
        this.movesInfo = new Array();
        for (index = 0, pos = 1; index < parseInt(obj.movesnode.cnt); index++, pos++) {
            var moveDetails = obj.movesnode["x" + pos].split(",");
            var moveType = "";
            switch (moveDetails[4]) {
            case "r":
                moveType = "MOVE";
                break;
            case "p":
                moveType = "PASS";
                break;
            case "s":
                moveType = "SWAP";
                break;
            case "c":
                moveType = "CHALLENGE";
                break;
            }
            this.movesInfo[index] = {
                uid: obj.gameinfo[moveDetails[1] + "email"],
                word: (moveDetails[4] != "s") ? moveDetails[2] : "",
                score: moveDetails[3],
                moveType: moveType
            };
        }
        this.messagesInfo = new Array();
        for (index = 0, pos = 1; index < parseInt(obj.messages.cnt); index++, pos++) {
            var messageDetails = null;
            if (obj.messages["m" + pos] != null) {
                messageDetails = obj.messages["m" + pos].split("~!~");
                this.messagesInfo[index] = {
                    uid: obj.gameinfo["p" + messageDetails[2] + "email"],
                    date: messageDetails[1],
                    msg: messageDetails[3]
                };
            } else {
                this.messagesInfo[index] = {
                    uid: null,
                    date: null,
                    msg: null
                };
            }
        }
        this.gameInfo = {
            gid: obj.gameinfo["gameid"],
            dic: obj.gameinfo["dictionary"].toUpperCase(),
            status: obj.gameinfo["status"].toUpperCase(),
            gameType: obj.gameinfo["gametype"].toUpperCase(),
            winner: obj.gameinfo["winner"],
            tilesInBag: obj.gameinfo["tilesinbag"],
            myTurn: ((obj.gameinfo["myturn"] == "y") ? true : false),
            myRack: obj.gameinfo["myrack"],
            turnUid: this.playersUid[parseInt(obj.gameinfo["currentturnpid"]) - 1],
            proUser: obj.gameinfo["prouser"]
        };
        if (obj.gameinfo["showChat"] == "y") {
            AppConstants.variables.showChat = true;
        } else {
            AppConstants.variables.showChat = false;
        }
        this.nodeString = obj.boardnode.nodeval;
        this.cellWeightString = obj.gameinfo.boarddes;
        this.tileString = obj.gameinfo.tilevalues;
        this.msgSpecsArr = obj.msgSpecs;

        this.boardLayout = obj.gameinfo.boarddes;        
        this.tileLeft = obj.gameinfo.tile_count;
    }
};
var Base64 = {
    _keyStr: "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",
    encode: function (input) {
        var output = "";
        var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
        var i = 0;
        input = Base64._utf8_encode(input);
        while (i < input.length) {
            chr1 = input.charCodeAt(i++);
            chr2 = input.charCodeAt(i++);
            chr3 = input.charCodeAt(i++);
            enc1 = chr1 >> 2;
            enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
            enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
            enc4 = chr3 & 63;
            if (isNaN(chr2)) {
                enc3 = enc4 = 64;
            } else {
                if (isNaN(chr3)) {
                    enc4 = 64;
                }
            }
            output = output + this._keyStr.charAt(enc1) + this._keyStr.charAt(enc2) + this._keyStr.charAt(enc3) + this._keyStr.charAt(enc4);
        }
        return output;
    },
    decode: function (input) {
        var output = "";
        var chr1, chr2, chr3;
        var enc1, enc2, enc3, enc4;
        var i = 0;
        input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");
        while (i < input.length) {
            enc1 = this._keyStr.indexOf(input.charAt(i++));
            enc2 = this._keyStr.indexOf(input.charAt(i++));
            enc3 = this._keyStr.indexOf(input.charAt(i++));
            enc4 = this._keyStr.indexOf(input.charAt(i++));
            chr1 = (enc1 << 2) | (enc2 >> 4);
            chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
            chr3 = ((enc3 & 3) << 6) | enc4;
            output = output + String.fromCharCode(chr1);
            if (enc3 != 64) {
                output = output + String.fromCharCode(chr2);
            }
            if (enc4 != 64) {
                output = output + String.fromCharCode(chr3);
            }
        }
        output = Base64._utf8_decode(output);
        return output;
    },
    _utf8_encode: function (string) {
        string = string.replace(/\r\n/g, "\n");
        var utftext = "";
        for (var n = 0; n < string.length; n++) {
            var c = string.charCodeAt(n);
            if (c < 128) {
                utftext += String.fromCharCode(c);
            } else {
                if ((c > 127) && (c < 2048)) {
                    utftext += String.fromCharCode((c >> 6) | 192);
                    utftext += String.fromCharCode((c & 63) | 128);
                } else {
                    utftext += String.fromCharCode((c >> 12) | 224);
                    utftext += String.fromCharCode(((c >> 6) & 63) | 128);
                    utftext += String.fromCharCode((c & 63) | 128);
                }
            }
        }
        return utftext;
    },
    _utf8_decode: function (utftext) {
        var string = "";
        var i = 0;
        var c = c1 = c2 = 0;
        while (i < utftext.length) {
            c = utftext.charCodeAt(i);
            if (c < 128) {
                string += String.fromCharCode(c);
                i++;
            } else {
                if ((c > 191) && (c < 224)) {
                    c2 = utftext.charCodeAt(i + 1);
                    string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
                    i += 2;
                } else {
                    c2 = utftext.charCodeAt(i + 1);
                    c3 = utftext.charCodeAt(i + 2);
                    string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
                    i += 3;
                }
            }
        }
        return string;
    }
};
var ErrorModel = {
    type: {
        "STARTGAMETILEPLACE": "First word must cover the star...",
        "TILESEQUENTIALPROBLEM": "Tiles must be in a single row or column...",
        "TILECONNECTPROBLEM": "Tiles must be connected...",
        "FIRSTTURNSINGLELETTER": "Please use at least two letters..."
    }
};
var BoardModel = {
    boardObject: null,
    cellWeightString: "WWWGWWWWWWWGWWWWWRWWWBWBWWWRWWWRWWWLWWWLWWWRWGWWWPWWWWWPWWWGWWWPWWWWWWWPWWWWWLWWWLWLWWWLWWWBWWWLWWWLWWWBWWWWWWWWWWWWWWWWWBWWWLWWWLWWWBWWWLWWWLWLWWWLWWWWWPWWWWWWWPWWWGWWWPWWWWWPWWWGWRWWWLWWWLWWWRWWWRWWWBWBWWWRWWWWWGWWWWWWWGWWW",
    cellWeightObject: null,
    nodeString: "",
    nodeObject: null,
    init: function (obj) {

        if(this.cellWeightString!=FeedDataModel.boardLayout){   //custom board
            AppConstants.variables.isCustomBoard = true;
            this.cellWeightString = FeedDataModel.boardLayout;
            var tempString = '';
            var cellWeightStrSplit = this.cellWeightString.split("",225);
            for(var i=0;i<15;i++){
                var  k = 0;
                for(var j=0;j<15;j++){
                    tempString += cellWeightStrSplit[i+k];
                    k += 15;
                }
            }           
            this.cellWeightString = tempString;
            
            this.cellWeightObject = {
                    R : {
                        color : "#bf0000",
                        caption : "3W"
                    },
                    P : {
                        color : "#f0a6ac",
                        caption : "2W"
                    },
                    B : {
                        color : "#205abb",
                        caption : "3L"
                    },
                    L : {
                        color : "#a6c5f1",
                        caption : "2L"
                    },
                    G : {
                        color : "#bf9f00",
                        caption : "4W"
                    },
                    W : {
                        color : "",
                        caption : ""
                    },
                    F : {
                        color : "#d1bb4c",
                        caption : "4L"
                    },
                    H : {
                        color : "#66d966",
                        caption : "5L"
                    },
                    I : {
                        color : "#00be00",
                        caption : "5W"
                    },
                    
                };
            
        }else{
            this.cellWeightObject = {
                R : {
                    color : "#d22323",
                    caption : "3W"
                },
                P : {
                    color : "#ffa0a0",
                    caption : "2W"
                },
                B : {
                    color : "#3264c8",
                    caption : "3L"
                },
                L : {
                    color : "#a0d3ff",
                    caption : "2L"
                },
                G : {
                    color : "#C4C400",
                    caption : "4W"
                },
                W : {
                    color : "",
                    caption : ""
                }   
                
            };
        }

        var cellDetails = null;
        if (obj != undefined) {
            if (obj.cellWeightString != undefined) {
                this.cellWeightString = obj.cellWeightString;
            }
            if (obj.nodeString != undefined) {
                this.nodeString = obj.nodeString;
                this.nodeObject = new Array();
                var eachCell = this.nodeString.split("|");
                for (var i = 0; i < eachCell.length; i++) {
                    cellDetails = eachCell[i].split(",");
                    this.nodeObject[cellDetails[1] + "-" + cellDetails[2]] = {
                        chr: cellDetails[0],
                        moveId: cellDetails[3]
                    };
                }
            }
        }
        this.boardObject = new Array();
        for (var yy = 0; yy < AppConstants.variables.boardRowCount; yy++) {
            var eachRow = new Array();
            for (var xx = 0; xx < AppConstants.variables.boardColCount; xx++) {
                var vCode = "";
                var vMoveId = 0;
                var weight = this.cellWeightObject[this.cellWeightString.charAt((xx * AppConstants.variables.boardColCount) + yy)];
                if (this.nodeObject != undefined && this.nodeObject[yy + "-" + xx] != undefined) {
                    vCode = this.nodeObject[yy + "-" + xx].chr;
                    vMoveId = this.nodeObject[yy + "-" + xx].moveId;
                }
                eachRow[xx] = {
                    chr: vCode,
                    moveId: vMoveId,
                    weightText: weight.caption,
                    weightColor: weight.color,
                    hasDraggedTile: false
                };
            }
            this.boardObject.push(eachRow);
        }
    },
    getMoveLettersToString: function () {
        var str = "";
        for (var yy = 0; yy < AppConstants.variables.boardRowCount; yy++) {
            for (var xx = 0; xx < AppConstants.variables.boardColCount; xx++) {
                var eachRow = this.getData(xx, yy);
                if (eachRow.chr != "" && !eachRow.hasDraggedTile) {
                    str += eachRow.chr;
                }
            }
        }
        return str;
    },
    setData: function (posX, posY, chr, isTemp) {
        if (!this.isPositionValid(posX, posY)) {
            return;
        }
        this.boardObject[posY][posX].chr = chr;
        this.boardObject[posY][posX].hasDraggedTile = isTemp;
    },
    getData: function (posX, posY) {
        if (!this.isPositionValid(posX, posY)) {
            return null;
        }
        return this.boardObject[posY][posX];
    },
    getDataByMoveId: function (moveid) {
        var posArr = [];
        for (var yy = 0; yy < AppConstants.variables.boardRowCount; yy++) {
            for (var xx = 0; xx < AppConstants.variables.boardColCount; xx++) {
                var eachRow = this.getData(xx, yy);
                if (eachRow.moveId == moveid) {
                    eachRow.x = xx;
                    eachRow.y = yy;
                    posArr.push(eachRow);
                }
            }
        }
        return posArr;
    },
    getVerticalEmptyCell: function (curX, curY, dir, traceDraggable) {
        var len = (dir == 1) ? AppConstants.variables.boardRowCount - 1 : 0;
        traceDraggable = (traceDraggable == undefined) ? false : traceDraggable;
        if (traceDraggable && this.boardObject[curY][curX].hasDraggedTile) {
            return {
                x: curX,
                y: curY
            };
        }
        for (var yy = curY + dir;; yy += dir) {
            if (dir == 1 && !(yy <= len)) {
                break;
            }
            if (dir == -1 && !(yy >= len)) {
                break;
            }
            if (traceDraggable) {
                if (this.boardObject[yy][curX].hasDraggedTile) {
                    return {
                        x: curX,
                        y: yy
                    };
                }
                continue;
            }
            if (this.boardObject[yy][curX].chr == "") {
                return {
                    x: curX,
                    y: yy
                };
            }
        }
        return null;
    },
    getHorizontalEmptyCell: function (curX, curY, dir, traceDraggable) {
        var len = (dir == 1) ? AppConstants.variables.boardColCount - 1 : 0;
        traceDraggable = (traceDraggable == undefined) ? false : traceDraggable;
        if (traceDraggable && this.boardObject[curY][curX].hasDraggedTile) {
            return {
                x: curX,
                y: curY
            };
        }
        for (var xx = curX + dir;; xx += dir) {
            if (dir == 1 && !(xx <= len)) {
                break;
            }
            if (dir == -1 && !(xx >= len)) {
                break;
            }
            if (traceDraggable) {
                if (this.boardObject[curY][xx].hasDraggedTile) {
                    return {
                        x: xx,
                        y: curY
                    };
                }
                continue;
            }
            if (this.boardObject[curY][xx].chr == "") {
                return {
                    x: xx,
                    y: curY
                };
            }
        }
        return null;
    },
    canRemoveCellData: function (posX, posY) {
        if (!this.isPositionValid(posX, posY)) {
            return false;
        }
        if (!this.boardObject[posY][posX].hasDraggedTile) {
            return false;
        }
        return true;
    },
    canAddCellData: function (posX, posY) {
        if (!this.isPositionValid(posX, posY)) {
            return false;
        }
        if (this.boardObject[posY][posX].hasDraggedTile) {
            return false;
        }
        return true;
    },
    isPositionValid: function (posX, posY) {
        if (posX < 0 || posX > AppConstants.variables.boardColCount - 1) {
            return false;
        }
        if (posY < 0 || posY > AppConstants.variables.boardRowCount - 1) {
            return false;
        }
        return true;
    },
    getTempScore: function () {
        var index = 0;
        var posArr = [];
        var words = [];
        var xDir = false;
        var yDir = false;
        for (var yy = 0; yy < AppConstants.variables.boardRowCount; yy++) {
            for (var xx = 0; xx < AppConstants.variables.boardColCount; xx++) {
                var eachRow = this.getData(xx, yy);
                if (eachRow.hasDraggedTile) {
                    posArr.push({
                        x: xx,
                        y: yy,
                        chr: eachRow.chr
                    });
                }
            }
        }
        if (posArr.length > 0) {
            for (index = 1; index < posArr.length; index++) {
                if (posArr[index].x == posArr[index - 1].x) {
                    xDir = true;
                } else {
                    xDir = false;
                    break;
                }
            }
            for (index = 1; index < posArr.length; index++) {
                if (posArr[index].y == posArr[index - 1].y) {
                    yDir = true;
                } else {
                    yDir = false;
                    break;
                }
            }
            if (!xDir && !yDir && posArr.length > 0) {
                xDir = true;
            }
            if (yDir) {
                words.push(this.getWordX(posArr[0].x, posArr[0].y));
                for (index = 0; index < posArr.length; index++) {
                    var word = this.getWordY(posArr[index].x, posArr[index].y);
                    if (word.length == 0) {
                        continue;
                    }
                    words.push(word);
                }
            } else {
                if (xDir) {
                    words.push(this.getWordY(posArr[0].x, posArr[0].y));
                    for (index = 0; index < posArr.length; index++) {
                        var word = this.getWordX(posArr[index].x, posArr[index].y);
                        if (word.length == 0) {
                            continue;
                        }
                        words.push(word);
                    }
                }
            }
        }
        var totalScore = 0;
        for (var i = 0; i < words.length; i++) {
            var score = 0;
            var pointW = 1;
            for (var j = 0; j < words[i].length; j++) {
                if (words[i][j].weight.charAt(1) == "W") {
                    pointW *= parseInt(words[i][j].weight.charAt(0));
                    score += parseInt(TileModel.getData(words[i][j].chr));
                } else {
                    if (words[i][j].weight.charAt(1) == "L") {
                        score += (parseInt(TileModel.getData(words[i][j].chr)) * parseInt(words[i][j].weight.charAt(0)));
                    } else {
                        score += parseInt(TileModel.getData(words[i][j].chr));
                    }
                }
            }
            score *= pointW;
            totalScore += score;
        }
        if (MovesModel.length() == 0) {
            totalScore *= 2;
        } else {
            if (MovesModel.length() == 1 && (MovesModel.getLastData().moveType == "PASS" || MovesModel.getLastData().moveType == "SWAP")) {
                totalScore *= 2;
            }
        }
        if (posArr.length == 7) {
            totalScore += 40;
        } else {
            if (posArr.length == 8) {
                totalScore += 50;
            }
        }
        return (totalScore == 0) ? "" : totalScore;
    },
    getWordX: function (xx, yy) {
        var word = [];
        for (var x = xx - 1; x >= 0; x--) {
            if (x < 0) {
                break;
            }
            if (this.getData(x, yy).chr == "") {
                break;
            }
        }
        x = (x < 0) ? 0 : x + 1;
        for (; x <= 14; x++) {
            if (x > 14) {
                break;
            }
            var data = this.getData(x, yy);
            if (data.chr == "") {
                break;
            }
            word.push({
                x: x,
                y: yy,
                chr: data.chr,
                weight: (data.hasDraggedTile) ? data.weightText : ""
            });
        }
        if (word.length == 1) {
            return [];
        }
        return word;
    },
    getWordY: function (xx, yy) {
        var word = [];
        for (var y = yy - 1; y >= 0; y--) {
            if (y < 0) {
                break;
            }
            if (this.getData(xx, y).chr == "") {
                break;
            }
        }
        y = (y < 0) ? 0 : y + 1;
        for (; y <= 14; y++) {
            if (y > 14) {
                break;
            }
            var data = this.getData(xx, y);
            if (data.chr == "") {
                break;
            }
            word.push({
                x: xx,
                y: y,
                chr: data.chr,
                weight: (data.hasDraggedTile) ? data.weightText : ""
            });
        }
        if (word.length == 1) {
            return [];
        }
        return word;
    },
    isTilePositionValid: function () {
        var index = 0;
        var posArr = [];
        var xDir = false;
        var yDir = false;
        var firstTurn = false;
        if (this.getData(7, 7).chr == "") {
            return {
                status: false,
                errorType: ErrorModel.type.STARTGAMETILEPLACE
            };
        } else {
            if (this.getData(7, 7).hasDraggedTile) {
                firstTurn = true;
            }
        }
        for (var yy = 0; yy < AppConstants.variables.boardRowCount; yy++) {
            for (var xx = 0; xx < AppConstants.variables.boardColCount; xx++) {
                var eachRow = this.getData(xx, yy);
                if (eachRow.hasDraggedTile) {
                    posArr.push({
                        x: xx,
                        y: yy,
                        chr: eachRow.chr
                    });
                }
            }
        }
        var xCount = 1;
        var yCount = 1;
        var lastX = posArr[0].x;
        var lastY = posArr[0].y;
        for (index = 1; index < posArr.length; index++) {
            if (posArr[index].x == lastX) {
                xCount++;
            }
            if (posArr[index].y == lastY) {
                yCount++;
            }
        }
        if (xCount == posArr.length) {
            xDir = true;
        } else {
            if (yCount == posArr.length) {
                yDir = true;
            }
        }
        if (!xDir && !yDir) {
            return {
                status: false,
                errorType: ErrorModel.type.TILESEQUENTIALPROBLEM
            };
        }
        var word = [];
        var data = null;
        var hasStaticTile = false;
        if (xDir) {
            for (index = posArr[0].y; index >= 0; index--) {
                data = this.getData(posArr[0].x, index);
                if (data.chr == "") {
                    break;
                }
            }
            for (index++; index < AppConstants.variables.boardRowCount; index++) {
                data = this.getData(posArr[0].x, index);
                if (data.chr == "") {
                    break;
                }
                word.push({
                    x: posArr[0].x,
                    y: index,
                    chr: data.chr,
                    hasDraggedTile: data.hasDraggedTile
                });
                if (!data.hasDraggedTile) {
                    hasStaticTile = true;
                }
            }
        } else {
            if (yDir) {
                for (index = posArr[0].x; index >= 0; index--) {
                    data = this.getData(index, posArr[0].y);
                    if (data.chr == "") {
                        break;
                    }
                }
                for (index++; index < AppConstants.variables.boardRowCount; index++) {
                    data = this.getData(index, posArr[0].y);
                    if (data.chr == "") {
                        break;
                    }
                    word.push({
                        x: index,
                        y: posArr[0].y,
                        chr: data.chr,
                        hasDraggedTile: data.hasDraggedTile
                    });
                    if (!data.hasDraggedTile) {
                        hasStaticTile = true;
                    }
                }
            }
        }
        if (word.length < posArr.length) {
            return {
                status: false,
                errorType: ErrorModel.type.TILECONNECTPROBLEM
            };
        }
        if (!hasStaticTile && !firstTurn) {
            var found = false;
            for (index = 0; index < posArr.length; index++) {
                var top = this.getData(posArr[index].x, posArr[index].y - 1);
                var right = this.getData(posArr[index].x + 1, posArr[index].y);
                var bottom = this.getData(posArr[index].x, posArr[index].y + 1);
                var left = this.getData(posArr[index].x - 1, posArr[index].y);
                if (top != null && top.chr != "" && !top.hasDraggedTile) {
                    found = true;
                    break;
                }
                if (right != null && right.chr != "" && !right.hasDraggedTile) {
                    found = true;
                    break;
                }
                if (bottom != null && bottom.chr != "" && !bottom.hasDraggedTile) {
                    found = true;
                    break;
                }
                if (left != null && left.chr != "" && !left.hasDraggedTile) {
                    found = true;
                    break;
                }
            }
            if (!found) {
                return {
                    status: false,
                    errorType: ErrorModel.type.TILECONNECTPROBLEM
                };
            }
        }
        if (MovesModel.length() == 0 && posArr.length == 1) {
            return {
                status: false,
                errorType: ErrorModel.type.FIRSTTURNSINGLELETTER
            };
        }
        return {
            status: true,
            moveObj: posArr
        };
    },
    getNextValidPosition: function () {
        var index = 0;
        var posArr = [];
        var xDir = false;
        var yDir = false;
        var nextPoint = {
            nextX: null,
            nextY: null
        };
        for (var yy = 0; yy < AppConstants.variables.boardRowCount; yy++) {
            for (var xx = 0; xx < AppConstants.variables.boardColCount; xx++) {
                var eachRow = this.getData(xx, yy);
                if (eachRow.hasDraggedTile) {
                    posArr.push({
                        x: xx,
                        y: yy,
                        chr: eachRow.chr
                    });
                }
            }
        }
        if (posArr.length < 2) {
            return nextPoint;
        }
        var xCount = 1;
        var yCount = 1;
        var lastX = posArr[0].x;
        var lastY = posArr[0].y;
        for (index = 1; index < posArr.length; index++) {
            if (posArr[index].x == lastX) {
                xCount++;
            }
            if (posArr[index].y == lastY) {
                yCount++;
            }
        }
        if (xCount == posArr.length) {
            xDir = true;
        } else {
            if (yCount == posArr.length) {
                yDir = true;
            }
        }
        if (!xDir && !yDir) {
            return nextPoint;
        }
        var data = null;
        var nextPosArr = [];
        if (xDir) {
            for (index = posArr[0].y; index >= 0; index--) {
                data = this.getData(posArr[0].x, index);
                if (data.chr == "") {
                    break;
                }
            }
            for (index++; index < AppConstants.variables.boardRowCount; index++) {
                data = this.getData(posArr[0].x, index);
                if (data.chr == "") {
                    nextPoint.nextX = posArr[0].x;
                    nextPoint.nextY = index;
                    break;
                }
                if (data.hasDraggedTile) {
                    nextPosArr.push({
                        x: posArr[0].x,
                        y: index
                    });
                }
            }
        } else {
            if (yDir) {
                for (index = posArr[0].x; index >= 0; index--) {
                    data = this.getData(index, posArr[0].y);
                    if (data.chr == "") {
                        break;
                    }
                }
                for (index++; index < AppConstants.variables.boardRowCount; index++) {
                    data = this.getData(index, posArr[0].y);
                    if (data.chr == "") {
                        nextPoint.nextX = index;
                        nextPoint.nextY = posArr[0].y;
                        break;
                    }
                    if (data.hasDraggedTile) {
                        nextPosArr.push({
                            x: index,
                            y: posArr[0].y
                        });
                    }
                }
            }
        }
        if (nextPosArr.length != posArr.length) {
            nextPoint.nextX = null;
            nextPoint.nextY = null;
        }
        return nextPoint;
    },
    update: function (obj) {
        for (var index = 0; index < obj.length; index++) {
            this.setData(obj[index].x, obj[index].y, obj[index].chr, false);
            this.boardObject[obj[index].y][obj[index].x].moveId = MovesModel.lastMoveId();
        }
        GameInfoModel.tilesInBag = parseInt(GameInfoModel.tilesInBag) - obj.length;
        GameInfoModel.tilesInBag = (GameInfoModel.tilesInBag < 0) ? 0 : GameInfoModel.tilesInBag;
    },
    updateChallenge: function () {
        var count = 0;
        for (var yy = 0; yy < AppConstants.variables.boardRowCount; yy++) {
            for (var xx = 0; xx < AppConstants.variables.boardColCount; xx++) {
                var eachRow = this.getData(xx, yy);
                if (eachRow.moveId == MovesModel.lastMoveId()) {
                    this.setData(xx, yy, "", false);
                    count;
                }
            }
        }
        GameInfoModel.tilesInBag = parseInt(GameInfoModel.tilesInBag) + count;
    },
    getLastPlayedWords: function () {
        var obj = this.getDataByMoveId(MovesModel.lastMoveId());
        var wordObjX = [];
        var wordObjY = [];
        for (var i = 0; i < obj.length; i++) {
            var wordX = this.getWordX(obj[i].x, obj[i].y);
            wordObjX.push(wordX);
            var wordY = this.getWordY(obj[i].x, obj[i].y);
            wordObjY.push(wordY);
        }
        return [wordObjX, wordObjY];
    },
    recall: function () {
        var tempData = [];
        for (var yy = 0; yy < AppConstants.variables.boardRowCount; yy++) {
            for (var xx = 0; xx < AppConstants.variables.boardColCount; xx++) {
                var eachRow = this.getData(xx, yy);
                if (eachRow.hasDraggedTile) {
                    this.setData(xx, yy, "", false);
                    tempData.push({
                        x: xx,
                        y: yy
                    });
                }
            }
        }
        return tempData;
    }
};
var TileModel = {
    langTileString: {
        "EN": "A,1|B,4|C,4|D,2|E,1|F,5|G,2|H,5|I,1|J,8|K,6|L,1|M,4|N,1|O,1|P,4|Q,12|R,1|S,1|T,2|U,1|V,5|W,5|X,8|Y,5|Z,12|a,0|b,0|c,0|d,0|e,0|f,0|g,0|h,0|i,0|j,0|k,0|l,0|m,0|n,0|o,0|p,0|q,0|r,0|s,0|t,0|u,0|v,0|w,0|x,0|y,0|z,0",
        "FR": "A,1|B,4|C,4|D,2|E,1|F,5|G,2|H,5|I,1|J,10|K,12|L,1|M,2|N,1|O,1|P,3|Q,8|R,1|S,1|T,1|U,1|V,5|W,12|X,12|Y,12|Z,12|a,0|b,0|c,0|d,0|e,0|f,0|g,0|h,0|i,0|j,0|k,0|l,0|m,0|n,0|o,0|p,0|q,0|r,0|s,0|t,0|u,0|v,0|w,0|x,0|y,0|z,0",
        "IT": "A,1|B,4|C,4|D,2|E,1|F,5|G,2|H,5|I,1|J,10|K,6|L,1|M,4|N,1|O,1|P,4|Q,12|R,1|S,1|T,2|U,1|V,5|W,5|X,10|Y,5|Z,12|a,0|b,0|c,0|d,0|e,0|f,0|g,0|h,0|i,0|j,0|k,0|l,0|m,0|n,0|o,0|p,0|q,0|r,0|s,0|t,0|u,0|v,0|w,0|x,0|y,0|z,0"
    },
    tileString: "",
    tileObject: null,
    init: function (obj) {
        if (obj != undefined && obj.tileString != undefined) {
            this.tileString = obj.tileString;
        } else {
            if (GameInfoModel.dic == "SOW" || GameInfoModel.dic == "TWL") {
                this.tileString = this.langTileString["EN"];
            } else {
                this.tileString = this.langTileString[GameInfoModel.dic];
            }
        }
        this.tileObject = new Array();
        var valueArr = this.tileString.split("|");
        for (var i = 0; i < valueArr.length; i++) {
            var splt = valueArr[i].split(",");
            this.tileObject[splt[0]] = splt[1];
        }
    },
    getData: function (ch) {
        return this.tileObject[ch];
    }
};
var Tile = {
    color: "tilePlayed",
    code: 0,
    displayText: "",
    scoreText: "",
    inRack: false,
    isRed: false,
    init: function (obj) {
        this.color = obj.color;
        this.code = obj.code.charCodeAt(0);
        this.inRack = obj.inRack;
        this.displayText = String.fromCharCode(this.code);
        this.scoreText = TileModel.getData(String.fromCharCode(this.code));
        this.isRed = false;
        if ((!this.inRack && (this.code >= 97 && this.code <= 122)) || (!this.inRack && this.code == 32)) {
            this.displayText = this.displayText.toUpperCase();
            this.scoreText = "0";
            this.isRed = true;
        }
        if ((this.inRack && this.code == 42) || (this.inRack && (this.code >= 97 && this.code <= 122)) || (this.inRack && this.code == 32)) {
            this.code = 42;
            this.displayText = " ";
            this.scoreText = " ";
        }
    },
    isSame: function (tile) {
        if (this.code == tile.code && this.inRack == tile.inRack) {
            return true;
        }
        return false;
    },
    makeClone: function () {
        var cl = new Array();
        cl["color"] = this.color;
        cl["code"] = this.code;
        cl["displayText"] = this.displayText;
        cl["scoreText"] = this.scoreText;
        cl["inRack"] = this.inRack;
        cl["isRed"] = this.isRed;
        return cl;
    }
};
var RackModel = {
    rackString: "",
    originalRackString: "",
    prackString: "",
    init: function () {
        this.prackString = this.originalRackString = this.rackString = GameInfoModel.myRack;
    },
    getValueByPosition: function (pos) {
        if (this.rackString.length - 1 < pos || 0 > pos) {
            return "";
        }
        return this.rackString.charAt(pos);
    },
    isCharInRack: function (ch) {
        ch = ch.toUpperCase();
        if (this.rackString.lastIndexOf(ch) == -1) {
            if (this.rackString.lastIndexOf("*") != -1) {
                return {
                    inRack: true,
                    isRed: true
                };
            }
            return {
                inRack: false,
                isRed: false
            };
        } else {
            return {
                inRack: true,
                isRed: false
            };
        }
    },
    deleteFromRack: function (ch) {
        if (this.rackString.lastIndexOf(ch) != -1) {
            ch = ch.toUpperCase();
        } else {
            if (this.rackString.lastIndexOf("*") != -1) {
                ch = "*";
            }
        }
        var tStr = "";
        var foundOnce = false;
        for (var index = 0; index < this.rackString.length; index++) {
            if (this.rackString.charAt(index) == ch && !foundOnce) {
                foundOnce = true;
                continue;
            }
            tStr += this.rackString.charAt(index);
        }
        this.rackString = tStr;
    },
    addToRack: function (ch) {
        if (ch.charCodeAt(0) >= 97 && ch.charCodeAt(0) <= 122) {
            this.rackString += "*";
        } else {
            this.rackString += ch;
        }
    },
    getRackLettersToString: function () {
        var str = "";
        for (var index = 0; index < this.originalRackString.length; index++) {
            str += this.originalRackString.charAt(index);
        }
        return str;
    },
    shuffle: function () {
        var a = this.rackString.split("");
        for (var i = a.length - 1; i > 0; i--) {
            var j = Math.floor(Math.random() * (i + 1));
            var tmp = a[i];
            a[i] = a[j];
            a[j] = tmp;
        }
        this.prackString = this.rackString = a.join("");
        for (var i = 0; i < this.originalRackString.length; i++) {}
    },
    sort: function () {
        var a = this.rackString.split("");
        a.sort();
        this.prackString = this.rackString = a.join("");
    },
    recall: function () {
        this.prackString = this.rackString = this.originalRackString;
    },
    getValueByOriginalPosition: function (pos) {
        if (this.prackString.length - 1 < pos || 0 > pos) {
            return "";
        }
        return this.prackString.charAt(pos);
    },
    getTilePosPlacedInBoard: function () {
        var or = this.prackString.split("");
        var ra = this.rackString.split("");
        var pos = [];
        for (var i = 0; i < or.length; i++) {
            var cd = or[i];
            var f = false;
            for (var j = 0; j < ra.length; j++) {
                if (cd == ra[j]) {
                    ra.splice(j, 1);
                    f = true;
                    break;
                }
            }
            if (!f) {
                pos.push(i);
            }
        }
        return pos;
    }
};
var ChatModel = {
    messageInfo: null,
    init: function (obj) {
        this.messageInfo = obj.messageInfo;
    },
    getData: function (pos) {
        return this.messageInfo[pos];
    },
    setData: function (obj) {
        this.messageInfo.push(obj);
    },
    length: function () {
        return this.messageInfo.length;
    }
};
var PlayersModel = {
    playersUid: null,
    playersInfo: null,
    init: function (obj) {
        this.playersUid = obj.playersUid;
        this.playersInfo = obj.playersInfo;
    },
    getInfo: function (index) {
        return this.playersInfo["_" + this.playersUid[index]];
    },
    getInfoByPid: function (pid) {
        return this.playersInfo["_" + this.playersUid[pid - 1]];
    },
    getUidByPid: function (index) {
        return this.playersUid[index - 1];
    },
    getInfoByUid: function (uid) {
        return this.playersInfo["_" + uid];
    },
    getPlayersCount: function () {
        return this.playersUid.length;
    },
    getMyUid: function () {
        return this.playersUid[AppConstants.variables.gamePid - 1];
    },
    updateMyScore: function (score) {
        var curScore = this.playersInfo["_" + this.playersUid[AppConstants.variables.gamePid - 1]].score;
        curScore = parseInt(curScore) + parseInt(score);
        this.playersInfo["_" + this.playersUid[AppConstants.variables.gamePid - 1]].score = curScore;
    },
    updateGameOver: function (p1score, p2score, p3score, p4score) {
        var arr = [p1score, p2score, p3score, p4score];
        for (var i = 0; i < this.playersUid.length; i++) {
            this.playersInfo["_" + this.playersUid[i]].score = parseInt(arr[i]);
        }
    }
};
var MovesModel = {
    movesInfo: null,
    init: function (obj) {
        this.movesInfo = obj.movesInfo;
    },
    getData: function (index) {
        return this.movesInfo[index];
    },
    getLastData: function () {
        return this.movesInfo[this.movesInfo.length - 1];
    },
    getPrevLastData: function () {
        return this.movesInfo[this.movesInfo.length - 2];
    },
    lastMoveId: function () {
        return this.movesInfo.length;
    },
    update: function (obj) {
        var newRow = [];
        for (var key in obj) {
            newRow[key] = obj[key];
        }
        this.movesInfo.push(newRow);
    },
    updateChallenge: function () {
        this.movesInfo[this.movesInfo.length - 1]["score"] = 0;
        this.movesInfo[this.movesInfo.length - 1]["moveType"] = "CHALLENGE";
    },
    length: function () {
        return this.movesInfo.length;
    }
};
var GameInfoModel = {
    gid: "",
    dic: "",
    status: "",
    gameType: "",
    winner: "",
    tilesInBag: "",
    myTurn: "",
    myRack: "",
    turnUid: "",
    proUser: "",
    init: function (obj) {
        this.gid = obj.gid;
        this.dic = obj.dic;
        this.status = obj.status;
        this.gameType = obj.gameType;
        this.winner = obj.winner;
        this.tilesInBag = obj.tilesInBag;
        this.myTurn = obj.myTurn;
        this.myRack = obj.myRack;
        this.turnUid = obj.turnUid;
        this.proUser = obj.proUser;
    },
    assign: function (obj) {
        for (var key in obj) {
            this[key] = obj[key];
        }
    },
    isProUser: function (uid) {
        if (this.proUser == undefined) {
            return false;
        }
        if (this.proUser[uid] == "y") {
            return true;
        } else {
            return false;
        }
    }
};
var BaseUI = {
    create: function (type, jsonObj) {
        var obj = document.createElement(type);
        for (key in jsonObj) {
            if (key == "style") {
                $(obj).css(jsonObj[key]);
            } else {
                $(obj).attr(key, jsonObj[key]);
            }
        }
        return obj;
    }
};
var RectTile = {
    create: function (tileObj) {
        var tileDiv = BaseUI.create("div", {
            "class": AppConstants.styleClasses[tileObj.color]
        });
        var tileText = BaseUI.create("div", {
            "class": AppConstants.styleClasses[tileObj.color + "Key"]
        });
        $(tileText).appendTo(tileDiv).html(tileObj.displayText);
        if (tileObj.isRed) {
            if (AppConstants.styleClasses.tileLastPlayed == tileObj.color) {
                $(tileText).css({
                    color: "#fe2232"
                });
            } else {
                $(tileText).css({
                    color: "#fe2232"
                });
            }
        } else {
            var tileScore = BaseUI.create("span", {
                "class": AppConstants.styleClasses.tileValue
            });
            if (tileObj.scoreText == 12) {
                $(tileText).css({
                    "font-size": "18px"
                });
                $(tileScore).css({
                    "font-size": "8px"
                });
            }
            $(tileScore).appendTo(tileText).html(tileObj.scoreText);
        }
        $(tileDiv).data({
            tile: tileObj.makeClone()
        });
        return tileDiv;
    }
};
var ActivityIndicator = {
    show: function (showMsg, auto) {
        var width = $("#" + AppConstants.elmIds.gameContainer).outerWidth(true);
        var height = $("#" + AppConstants.elmIds.gameContainer).outerHeight(true);
        var overDiv = BaseUI.create("div", {
            "class": AppConstants.styleClasses.activityOver
        });
        $(overDiv).fadeTo("fast", 0).appendTo("#" + AppConstants.elmIds.gameContainer).css({
            "left": $("#" + AppConstants.elmIds.gameContainer).position().left + "px",
            "top": $("#" + AppConstants.elmIds.gameContainer).position().top + "px",
            "width": width + "px",
            "height": height + "px"
        });
        var loaderDiv = BaseUI.create("div", {
            "class": AppConstants.styleClasses.activityLoader
        });
        $(loaderDiv).appendTo("#" + AppConstants.elmIds.gameContainer).css({
            "left": ($("#" + AppConstants.elmIds.gameContainer).position().left + (width / 2) - ($(loaderDiv).outerWidth(true) / 2)) + "px",
            "top": (($("#" + AppConstants.elmIds.gameContainer).position().top + height / 2) - ($(loaderDiv).outerHeight(true) / 2)) + "px"
        }).append("<div>" + showMsg + "</div>");
        if (auto) {
            $(loaderDiv).css({
                "cursor": "pointer"
            }).bind({
                mousedown: function () {
                    ActivityIndicator.hide();
                }
            });
            setTimeout((function () {
                return function () {
                    ActivityIndicator.hide();
                };
            })(), 5000);
        } else {
            $(loaderDiv).find("div").append("please wait...");
        }
    },
    hide: function () {
        $("." + AppConstants.styleClasses.activityOver).remove();
        $("." + AppConstants.styleClasses.activityLoader).remove();
    }
};
var UIEvent = {
    chatPanel: {
        send: function (event, msg) {
            var bool = this.validateMessage(msg);
            if (!bool) {
                return false;
            }
            GameController.postRequest({
                action: GameController.postRequestType.message,
                message: msg
            });
            return true;
        },
        validateMessage: function (msg) {
            if ($.trim(msg).length == 0) {
                return false;
            }
            return true;
        }
    },
    dicPanel: {
        outerDic: {
            mouseup: function (event, searchText) {
                if (searchText != "") {
                    UIEvent.dicPanel.outerDic.dojob(searchText);
                }
            },
            keyup: function (event, searchText) {
                if (event.keyCode == 13 && searchText != "") {
                    UIEvent.dicPanel.outerDic.dojob(searchText);
                }
            },
            dojob: function (searchText) {
                var lnk = AppConstants.variables.urlOuterDicSearch.EN;
                var eng = true;
                if (GameInfoModel.dic == "FR") {
                    lnk = AppConstants.variables.urlOuterDicSearch.FR;
                    eng = false;
                } else {
                    if (GameInfoModel.dic == "IT") {
                        lnk = AppConstants.variables.urlOuterDicSearch.IT;
                        eng = false;
                    }
                }
                if (eng) {
                    window.open("http://www.oneworddaily.com/?action=search&search=" + searchText, "_blank");
                } else {
                    window.open(lnk + "?pid=aff34&mode=w&Word=" + searchText, "_blank");
                }
            }
        },
        innerDic: {
            mouseup: function (event, searchText) {
                if (searchText != "") {
                    GameController.postRequest({
                        action: GameController.postRequestType.diccheck,
                        dicObj: {
                            searchText: searchText,
                            dicType: GameInfoModel.dic.toLowerCase()
                        }
                    });
                }
            },
            keyup: function (event, searchText) {
                if (event.keyCode == 13) {
                    if (searchText != "") {
                        GameController.postRequest({
                            action: GameController.postRequestType.diccheck,
                            dicObj: {
                                searchText: searchText,
                                dicType: GameInfoModel.dic.toLowerCase()
                            }
                        });
                    }
                }
            }
        }
    },
    board: {
        tileDrop: function (event, ui, auto) {
            var cell = null;
            var draggable = ui.draggable;
            var inRack = false;
            if ($(draggable).data("tile") == undefined) {
                return;
            }
            $(this).droppable({
                disabled: true
            });
            var dropOverObj = null;
            if ($(this).parent().attr("id") == $(RackPanel.rackDOM).attr("id")) {
                if ($(this).attr("id") == draggable.parent().attr("id")) {
                    dropOverObj = null;
                } else {
                    dropOverObj = $(this).find("." + AppConstants.styleClasses.tileRack);
                    if (dropOverObj.length > 0) {
                        var d = $(dropOverObj).data("tile");
                        $(this).find("." + AppConstants.styleClasses.tileRack).remove();
                        $(dropOverObj).data("tile", d);
                    } else {
                        dropOverObj = null;
                    }
                    $(this).droppable({
                        disabled: false
                    });
                }
            }
            if ($(this).parent().attr("id") == $(BoardPanel.boardDOM).attr("id")) {
                cell = BoardPanel.getTileContainerIdToXY($(this).attr("id"));
                if ($(draggable).data("tile").code == 42) {
                    BlankTilePopup.open(cell.x, cell.y);
                }
                BoardModel.setData(cell.x, cell.y, (draggable.data("tile").isRed) ? draggable.data("tile").displayText.toLowerCase() : draggable.data("tile").displayText, true);
            }
            if ($(this).parent().attr("id") == $(RackPanel.rackDOM).attr("id")) {
                inRack = true;
                RackModel.addToRack((draggable.data("tile").isRed) ? draggable.data("tile").displayText.toLowerCase() : draggable.data("tile").displayText);
            }
            Tile.init({
                color: draggable.data("tile").color,
                code: (draggable.data("tile").isRed) ? draggable.data("tile").displayText.toLowerCase() : draggable.data("tile").displayText,
                inRack: inRack
            });
            var tile_div = RectTile.create(Tile);
            $(tile_div).appendTo(this).draggable({
                revert: "invalid",
                zIndex: 2700
            }).bind({
                click: RackPanel.autoClick
            });
            if (inRack) {
                $(tile_div).position({
                    of: $(this),
                    offset: "top"
                });
            } else {
                $(tile_div).css({
                    left: "0px",
                    top: "0px"
                });
            }
            if (auto != undefined && auto) {
                $(tile_div).show("puff", [], 100);
            }
            if (AppConstants.variables.handheldDevice && !AppConstants.variables.androidDevice) {
                $(tile_div).draggable({
                    cursorAt: {
                        top: 70
                    },
                    scroll: false
                });
            } else {
                if (AppConstants.variables.androidDevice) {
                    $(tile_div).draggable({
                        scroll: false
                    });
                }
            }
            if ($(draggable).parent().parent().attr("id") == $(BoardPanel.boardDOM).attr("id")) {
                cell = BoardPanel.getTileContainerIdToXY($(draggable).parent().attr("id"));
                BoardModel.setData(cell.x, cell.y, "", false);
            }
            if ($(draggable).parent().parent().attr("id") == $(RackPanel.rackDOM).attr("id")) {
                RackModel.deleteFromRack($(draggable).data("tile").displayText);
            }
            $("#" + BoardPanel.ids.cellArrow).parent().data({
                arrowId: 0
            });
            $("#" + BoardPanel.ids.cellArrow).remove();
            $(draggable).parent().droppable({
                disabled: false,
                drop: UIEvent.board.tileDrop
            });
            if ($(draggable).data("tile").code != 42) {
                RackPanel.updateScore(BoardModel.getTempScore());
            } else {
                $(tile_div).draggable({
                    disabled: true
                });
            }
            if (auto != undefined && auto) {
                $(draggable).effect("puff", [], 100, function () {
                    $(draggable).remove();
                });
            } else {
                $(draggable).remove();
            }
            if (dropOverObj != null) {
                var drpIndex = $(this).attr("id").split("_")[1];
                var spIndex = -1;
                for (var i = 0; i < 8; i++) {
                    if ($("#" + RackPanel.ids.tile + "_" + i).html() == "") {
                        spIndex = i;
                    }
                }
                if (spIndex == -1) {
                    spIndex = parseInt(draggable.parent().attr("id").split("_")[1]);
                }
                if (drpIndex > spIndex) {
                    for (var ss = spIndex; ss < drpIndex; ss++) {
                        $("#" + RackPanel.ids.tile + "_" + ss).find("." + AppConstants.styleClasses.tileRack).remove();
                        var tdm = null;
                        if (ss == drpIndex - 1) {
                            Tile.init({
                                color: $(dropOverObj).data("tile").color,
                                code: ($(dropOverObj).data("tile").isRed) ? $(dropOverObj).data("tile").displayText.toLowerCase() : $(dropOverObj).data("tile").displayText,
                                inRack: true
                            });
                            tdm = RectTile.create(Tile);
                            $(tdm).appendTo($("#" + RackPanel.ids.tile + "_" + ss)).draggable({
                                revert: "invalid",
                                zIndex: 2700
                            }).bind({
                                click: RackPanel.autoClick
                            });
                            $(tdm).position({
                                of: $("#" + RackPanel.ids.tile + "_" + ss),
                                offset: "0,0"
                            });
                        } else {
                            var obj = $("#" + RackPanel.ids.tile + "_" + (ss + 1)).find("." + AppConstants.styleClasses.tileRack);
                            Tile.init({
                                color: $(obj).data("tile").color,
                                code: ($(obj).data("tile").isRed) ? $(obj).data("tile").displayText.toLowerCase() : $(obj).data("tile").displayText,
                                inRack: true
                            });
                            tdm = RectTile.create(Tile);
                            $(tdm).appendTo($("#" + RackPanel.ids.tile + "_" + ss)).draggable({
                                revert: "invalid",
                                zIndex: 2700
                            }).bind({
                                click: RackPanel.autoClick
                            });
                            $(tdm).position({
                                of: $("#" + RackPanel.ids.tile + "_" + ss),
                                offset: "0,0"
                            });
                        }
                    }
                } else {
                    if (drpIndex < spIndex) {
                        for (var ss = spIndex; ss > drpIndex; ss--) {
                            $("#" + RackPanel.ids.tile + "_" + ss).find("." + AppConstants.styleClasses.tileRack).remove();
                            var tdm = null;
                            if (ss == (parseInt(drpIndex) + 1)) {
                                Tile.init({
                                    color: $(dropOverObj).data("tile").color,
                                    code: ($(dropOverObj).data("tile").isRed) ? $(dropOverObj).data("tile").displayText.toLowerCase() : $(dropOverObj).data("tile").displayText,
                                    inRack: true
                                });
                                tdm = RectTile.create(Tile);
                                $(tdm).appendTo($("#" + RackPanel.ids.tile + "_" + ss)).draggable({
                                    revert: "invalid",
                                    zIndex: 2700
                                }).bind({
                                    click: RackPanel.autoClick
                                });
                                $(tdm).position({
                                    of: $("#" + RackPanel.ids.tile + "_" + ss),
                                    offset: "0,0"
                                });
                            } else {
                                var obj = $("#" + RackPanel.ids.tile + "_" + (ss - 1)).find("." + AppConstants.styleClasses.tileRack);
                                if (obj.length == 0) {
                                    continue;
                                }
                                Tile.init({
                                    color: $(obj).data("tile").color,
                                    code: ($(obj).data("tile").isRed) ? $(obj).data("tile").displayText.toLowerCase() : $(obj).data("tile").displayText,
                                    inRack: true
                                });
                                tdm = RectTile.create(Tile);
                                $(tdm).appendTo($("#" + RackPanel.ids.tile + "_" + ss)).draggable({
                                    revert: "invalid",
                                    zIndex: 2700
                                }).bind({
                                    click: RackPanel.autoClick
                                });
                                $(tdm).position({
                                    of: $("#" + RackPanel.ids.tile + "_" + ss),
                                    offset: "0,0"
                                });
                            }
                        }
                    }
                }
                $(this).droppable({
                    disabled: false
                });
            }
            if (GameInfoModel.myTurn) {
                if (RackModel.rackString.length < RackModel.originalRackString.length) {
                    ActionPanel.change(ActionPanel.type.TURN_AND_TILEPLACED);
                } else {
                    ActionPanel.change(ActionPanel.type.TURN_AND_IDEAL);
                }
            }
        },
        playHome: function () {
            GameController.postRequest({
                action: GameController.postRequestType.home
            });
        },
        playNextGame: function () {
            GameController.postRequest({
                action: GameController.postRequestType.nextGame
            });
        },
        playRematch: function () {
            GameController.postRequest({
                action: GameController.postRequestType.rematch
            });
        },
        playDelete: function () {
            GameController.postRequest({
                action: GameController.postRequestType.deleteGame
            });
        },
        playResign: function () {
            GameController.postRequest({
                action: GameController.postRequestType.resignGame
            });
        },
        playRefresh: function () {
            GameController.postRequest({
                action: GameController.postRequestType.refresh
            });
        },
        playChallenge: function () {
            if (!GameInfoModel.myTurn) {
                return;
            }
            GameController.postRequest({
                action: GameController.postRequestType.challenge
            });
        },
        playSwap: function (swapText) {
            if (!GameInfoModel.myTurn) {
                return;
            }
            GameController.postRequest({
                action: GameController.postRequestType.swap,
                swapText: swapText
            });
        },
        playMove: function () {
            if (!GameInfoModel.myTurn) {
                return;
            }
            if (BlankTilePopup.showing) {
                ActivityIndicator.show("Select a letter for the blank tile...", true);
                return;
            }
            var response = BoardModel.isTilePositionValid();
            if (!response.status) {
                ActivityIndicator.show(response.errorType, true);
            } else {
                GameController.postRequest({
                    action: GameController.postRequestType.move,
                    moveObj: response.moveObj
                });
            }
        },
        playPass: function () {
            if (!GameInfoModel.myTurn) {
                return;
            }
            GameController.postRequest({
                action: GameController.postRequestType.pass
            });
        },
        inputKeyUp: function (event) {
            $(this).val("");
            switch (event.keyCode) {
            case 13:
                if (!GameInfoModel.myTurn) {
                    return;
                }
                var response = BoardModel.isTilePositionValid();
                if (!response.status) {
                    ActivityIndicator.show(response.errorType, true);
                } else {
                    if (AppConstants.variables.askBeforePlay) {
                        PopUpBox.open({
                            title: "Play Move",
                            body: "Are you sure you wish to play this move?",
                            proceed: {
                                text: "OK",
                                execute: ActionPanel.doAction,
                                param: {
                                    action: "CONFIRMPLAY"
                                }
                            },
                            abort: {
                                text: "Cancel"
                            }
                        });
                    } else {
                        GameController.postRequest({
                            action: GameController.postRequestType.move,
                            moveObj: response.moveObj
                        });
                    }
                }
                break;
            case 37:
                BoardPanel.arrowMoveHorizontal(-1);
                break;
            case 38:
                BoardPanel.arrowMoveVertical(-1);
                break;
            case 39:
                BoardPanel.arrowMoveHorizontal(1);
                break;
            case 40:
                BoardPanel.arrowMoveVertical(1);
                break;
            case 8:
                BoardPanel.keyUpTileRemove();
                break;
            case 32:
                RackPanel.shuffle();
                break;
            default:
                if (event.keyCode >= 65 && event.keyCode <= 90) {
                    var str = String.fromCharCode(event.keyCode);
                    var rackResp = RackModel.isCharInRack(str);
                    if (rackResp.inRack) {
                        BoardPanel.keyUpTileDrop(str, rackResp.isRed);
                    }
                }
            }
        },
        showArrow: function (event) {
            if (event.which != undefined && event.which != 1) {
                return;
            }
            BlankTilePopup.hideAndUpdateRack();
            var cell = BoardPanel.getTileContainerIdToXY($(this).attr("id"));
            if (!BoardModel.getData(cell.x, cell.y).hasDraggedTile) {
                var arrowDiv = null;
                if ($(this).data("arrowId") == 0 || $(this).data("arrowId") == undefined) {
                    arrowDiv = BaseUI.create("div", {
                        "id": BoardPanel.ids.cellArrow,
                        "class": AppConstants.styleClasses.tileContainer_rightArraw
                    });
                    $("#" + BoardPanel.ids.cellArrow).parent().data({
                        arrowId: 0
                    });
                    $("#" + BoardPanel.ids.cellArrow).remove();
                    $(arrowDiv).appendTo(this).position({
                        of: $(this),
                        offset: "0,0"
                    });
                    $(this).data({
                        arrowId: 1
                    });
                    $("#" + BoardPanel.ids.hiddenInputBox).focus();
                } else {
                    if ($(this).data("arrowId") == 1) {
                        arrowDiv = BaseUI.create("div", {
                            "id": BoardPanel.ids.cellArrow,
                            "class": AppConstants.styleClasses.tileContainer_downArrow
                        });
                        $("#" + BoardPanel.ids.cellArrow).parent().data({
                            arrowId: 0
                        });
                        $("#" + BoardPanel.ids.cellArrow).remove();
                        $(arrowDiv).appendTo(this).position({
                            of: $(this),
                            offset: "1,0"
                        });
                        $(this).data({
                            arrowId: 2
                        });
                        $("#" + BoardPanel.ids.hiddenInputBox).focus();
                    } else {
                        if ($(this).data("arrowId") > 0) {
                            $("#" + BoardPanel.ids.cellArrow).remove();
                            $(this).data({
                                arrowId: 0
                            });
                        }
                    }
                }
            }
        }
    }
};
var PopUpBox = {
    showing: false,
    ids: {
        popUp: "GamePopUpBox",
        popUpTitle: "PopUpTitle",
        popUpBody: "PopUpBody",
        popUpPrceedButton: "PopUpProceedButton",
        popUpAbortButton: "PopUpAbortButton"
    },
    create: function () {
        var popUp = '<div class="popUp" id="' + this.ids.popUp + '"><div class="contain">' + '<div class="header" id="' + this.ids.popUpTitle + '"></div>' + '<div class="body" id="' + this.ids.popUpBody + '"></div>' + '<div class="footer">' + '<a class="blueButton" id="' + this.ids.popUpPrceedButton + '"></a>' + '<a class="redButton" id="' + this.ids.popUpAbortButton + '"></a>' + "</div></div></div>";
        $(popUp).appendTo("#" + AppConstants.elmIds.gameContainer);
        var left = $("#" + AppConstants.elmIds.gameContainer).position().left + ($("#" + AppConstants.elmIds.gameContainer).outerWidth(true) / 2) - ($("#" + this.ids.popUp).outerWidth(true) / 2);
        var top = $("#" + AppConstants.elmIds.gameContainer).position().top + ($("#" + AppConstants.elmIds.gameContainer).outerHeight(true) / 2) - ($("#" + this.ids.popUp).outerHeight(true) / 2);
        if (AppConstants.variables.hideAdvert == "y") {
            top = top + 98;
        }
        $("#" + this.ids.popUp).css({
            "left": left + "px",
            "top": top + "px"
        });
    },
    open: function (obj) {
        if (this.showing) {
            $("#" + PopUpBox.ids.popUp).hide();
        }
        $("#" + this.ids.popUpTitle).html(obj.title);
        $("#" + this.ids.popUpBody).html(obj.body);
        $("#" + this.ids.popUp).draggable({
            handle: ".header",
            containment: "#" + AppConstants.elmIds.gameContainer
        }).css({
            "z-index": 3000,
            position: "absolute"
        }).fadeIn();
        if (obj.proceed != undefined && obj.proceed.feedback == 1) {
            $(".popUp .footer .blueButton").hide();
            $(".popUp .footer").html('<a href="http://lexulous.uservoice.com/" target="_blank" class="blueButton" style="margin-left:75px">Support</a>');
        } else {
            if (obj.proceed != undefined) {
                $("#" + this.ids.popUpPrceedButton).unbind().html(obj.proceed.text).bind({
                    mouseup: function () {
                        obj.proceed.execute(obj.proceed.param);
                        $("#" + PopUpBox.ids.popUp).fadeOut();
                        PopUpBox.showing = false;
                    }
                });
            } else {
                $(".popUp .footer .blueButton").hide();
            }
        }
        if (obj.abort != undefined) {
            $("#" + this.ids.popUpAbortButton).html(obj.abort.text).bind({
                mouseup: function () {
                    $("#" + PopUpBox.ids.popUp).fadeOut();
                    PopUpBox.showing = false;
                }
            });
        } else {
            $(".popUp .footer .redButton").hide();
        }
        this.showing = true;
    },
    destroy: function () {
        $("#" + this.ids.popUp).remove();
    }
};
var HeaderPanel = {
    langType: {
        "SOW": "UK",
        "TWL": "US",
        "FR": "French",
        "IT": "Italian"
    },
    create: function () {
        var headerPanelDiv = $("#" + AppConstants.elmIds.headerPanel);
        if (GameInfoModel.myTurn) {
            $(headerPanelDiv).append('<span class="yourTurn">Your Turn</span>');
        }
        $(headerPanelDiv).addClass(AppConstants.styleClasses.headerPanel);
    },
    destroy: function () {
        $("#" + AppConstants.elmIds.headerPanel).empty();
    },
    addH2Hstats: function (data) {
        if (data.check == "Success") {
            var lostPercent = (data.completed == 0) ? 0 : ((data.lost * 100) / data.completed).toPrecision(2);
            var wonPercent = (data.completed == 0) ? 0 : ((data.won * 100) / data.completed).toPrecision(2);
            var oppname = (AppConstants.variables.gamePid == 1) ? PlayersModel.getInfo(1).name : PlayersModel.getInfo(0).name;
            $("#" + AppConstants.elmIds.headerPanel).find(".gameType").append('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#999;">You vs. ' + oppname + " : Games " + data.completed + " | You won " + data.won + "(" + lostPercent + "%) | Lost " + data.lost + " (" + wonPercent + "%) | Draws " + data.drawn + "</span>");
        }
    }
};
var BodyPanel = {
    create: function () {
        $("#" + AppConstants.elmIds.bodyPanel).addClass(AppConstants.styleClasses.bodyPanel);
        var leftPanelDiv = $("#" + AppConstants.elmIds.leftPanel);
        $(leftPanelDiv).addClass(AppConstants.styleClasses.bodyPanel_leftPanel);
        if (!AppConstants.variables.boardViewing) {
            BoardPanel.create();
            AppConstants.variables.boardViewing = true;
        } else {
            $("#elex_boardPanel li").find(".tileLastPlayed").removeClass("tileLastPlayed").addClass("tilePlayed");
            $("#elex_boardPanel li").find(".tileLastPlayedKey").removeClass("tileLastPlayedKey").addClass("tilePlayedKey");
            var x_pos = new Array();
            var y_pos = new Array();
            $.each($("#elex_boardPanel").find(".tileRack"), function (index, val) {
                var t = $(this).parent("li").attr("id");
                var temp_cor = t.split("_");
                if (x_pos.indexOf(temp_cor[1]) == -1) {
                    x_pos.push(temp_cor[1]);
                }
                if (y_pos.indexOf(temp_cor[2]) == -1) {
                    y_pos.push(temp_cor[2]);
                }
            });
            for (var yy = 0; yy < y_pos.length; yy++) {
                for (var xx = 0; xx < x_pos.length; xx++) {
                    var tile_li = "#BoardCell_" + x_pos[xx] + "_" + y_pos[yy] + "";
                    var cellData = BoardModel.getData(x_pos[xx], y_pos[yy]);
                    $(tile_li).empty();
                    if (cellData.weightText != "") {
                        var tile_span = BaseUI.create("span", {
                            "class": AppConstants.styleClasses.boardPanel_bonusText,
                            "draggable": false
                        });
                        if (cellData.weightText == "3L" || cellData.weightText == "3W" || cellData.weightText == "4L") {
                            $(tile_span).css({
                                color: "#ffffff"
                            });
                        }
                        $(tile_span).html(cellData.weightText).appendTo(tile_li);
                        if (AppConstants.variables.handheldDevice) {
                            if (!AppConstants.variables.showNumberBoard) {
                                $(tile_span).css("visibility", "hidden");
                            }
                        } else {
                            if (AppConstants.variables.showNumberBoard) {
                                if (cellData.chr != "") {
                                    $(tile_span).css("visibility", "visible");
                                } else {
                                    $(tile_span).css("visibility", "visible");
                                }
                            } else {
                                $(tile_span).css("visibility", "hidden");
                            }
                        }
                    }
                    if (cellData.chr != "") {
                        var color = AppConstants.styleClasses.tilePlayed;
                        if (MovesModel.lastMoveId() == cellData.moveId) {
                            color = AppConstants.styleClasses.tileLastPlayed;
                        }
                        Tile.init({
                            color: color,
                            code: cellData.chr,
                            inRack: false
                        });
                        var tile_div = RectTile.create(Tile);
                        $(tile_div).appendTo(tile_li).css({
                            "z-index": 200,
                            "left": "0px",
                            "top": "0px"
                        });
                        if (!AppConstants.variables.handheldDevice) {
                            $(tile_div).bind({
                                mousedown: function (event) {
                                    if (event.which != undefined && event.which != 1) {
                                        return;
                                    }
                                    $(this).fadeOut(500, function () {
                                        $(this).fadeIn(500);
                                    });
                                },
                                mouseup: function (event) {
                                    if (event.which != undefined && event.which != 1) {
                                        return;
                                    }
                                    $(this).fadeIn(500);
                                },
                                mouseout: function (event) {
                                    if (event.which != undefined && event.which != 1) {
                                        return;
                                    }
                                    $(this).fadeIn(500);
                                }
                            });
                        }
                        if (!AppConstants.variables.handheldDevice) {
                            if (cellData.chr == "") {
                                $(tile_li).bind({
                                    mouseup: UIEvent.board.showArrow
                                });
                            } else {
                                $("#BoardCellArrow").remove();
                                $(tile_li).unbind({
                                    mouseup: UIEvent.board.showArrow
                                });
                            }
                        }
                    }
                }
            }
        }
        ActionPanel.create();
        RackPanel.create();
        var rightPanelDiv = $("#" + AppConstants.elmIds.rightPanel);
        $(rightPanelDiv).addClass(AppConstants.styleClasses.bodyPanel_rightPanel);
        OptionMenu.create();
        PlayerList.create();
        InfoPanel.create();
        CombinedPanel.create();
        ChatPanel.scrollToBottom();
    },
    destroy: function () {
        if (!AppConstants.variables.boardViewing) {
            BoardPanel.destroy();
        }
        ActionPanel.destroy();
        RackPanel.destroy();
        OptionMenu.destroy();
        PlayerList.destroy();
        InfoPanel.destroy();
        CombinedPanel.destroy();
    }
};
var BoardPanel = {
    boardDOM: null,
    ids: {
        boardCell: "BoardCell",
        cellArrow: "BoardCellArrow",
        hiddenInputBox: "BoardHiddenInputBox"
    },
    resizeBoard: function () {
        $("#" + AppConstants.elmIds.gameContainer).css({
            "visibility": "hidden"
        });
        var boardPosition = $("#" + AppConstants.elmIds.boardPanel).position();
        for (var yy = 0; yy < AppConstants.variables.boardColCount; yy++) {
            for (var xx = 0; xx < AppConstants.variables.boardRowCount; xx++) {
                var left = boardPosition.left + $("#" + this.ids.boardCell + "_" + xx + "_" + yy).data("resizeLeft");
                var top = boardPosition.top + $("#" + this.ids.boardCell + "_" + xx + "_" + yy).data("resizeTop");
                $("#" + this.ids.boardCell + "_" + xx + "_" + yy).css({
                    "left": left + "px",
                    "top": top + "px"
                });
            }
        }
        $("#" + AppConstants.elmIds.gameContainer).css({
            "visibility": "visible"
        });
    },
    create: function () {
        $("#" + AppConstants.elmIds.boardPanelCont).addClass(AppConstants.styleClasses.boardPanelCont);
        this.boardDOM = $("#" + AppConstants.elmIds.boardPanel);
        this.boardDOM.addClass(AppConstants.styleClasses.boardPanel);
        var boardPosition = this.boardDOM.position();
        for (var yy = 0; yy < AppConstants.variables.boardColCount; yy++) {
            for (var xx = 0; xx < AppConstants.variables.boardRowCount; xx++) {
                var tile_li = BaseUI.create("li", {
                    "id": this.ids.boardCell + "_" + xx + "_" + yy,
                    "class": AppConstants.styleClasses.boardPanel_tileContainer
                });
                if (xx == 7 && yy == 7) {
                    $(tile_li).addClass(AppConstants.styleClasses.tileContainer_starImg);
                }
                $(tile_li).css({
                    "border-top": "1px solid #aaa",
                    "border-left": "1px solid #aaa"
                });
                if (yy == AppConstants.variables.boardRowCount - 1 && xx == AppConstants.variables.boardColCount - 1) {
                    $(tile_li).css({
                        "border-bottom": "1px solid #aaa",
                        "border-right": "1px solid #aaa",
                        "width": (AppConstants.variables.boardCellHeight - 2) + "px",
                        "height": (AppConstants.variables.boardCellHeight - 2) + "px",
                        "left": (boardPosition.left + ((AppConstants.variables.boardCellWidth - 1) * xx)) + "px",
                        "top": (boardPosition.top + ((AppConstants.variables.boardCellHeight - 1) * yy)) + "px"
                    });
                    $(tile_li).data({
                        resizeLeft: ((AppConstants.variables.boardCellWidth - 1) * xx),
                        resizeTop: ((AppConstants.variables.boardCellHeight - 1) * yy)
                    });
                } else {
                    if (yy == AppConstants.variables.boardRowCount - 1) {
                        $(tile_li).css({
                            "border-bottom": "1px solid #aaa",
                            "width": (AppConstants.variables.boardCellHeight - 1) + "px",
                            "height": (AppConstants.variables.boardCellHeight - 2) + "px",
                            "left": (boardPosition.left + (AppConstants.variables.boardCellWidth - 1) * xx) + "px",
                            "top": (boardPosition.top + (AppConstants.variables.boardCellHeight * yy) - yy) + "px"
                        });
                        $(tile_li).data({
                            resizeLeft: ((AppConstants.variables.boardCellWidth - 1) * xx),
                            resizeTop: ((AppConstants.variables.boardCellHeight * yy) - yy)
                        });
                    } else {
                        if (xx == AppConstants.variables.boardColCount - 1) {
                            $(tile_li).css({
                                "border-right": "1px solid #aaa",
                                "width": (AppConstants.variables.boardCellHeight - 2) + "px",
                                "height": (AppConstants.variables.boardCellHeight - 1) + "px",
                                "left": ((boardPosition.left + (AppConstants.variables.boardCellWidth * xx)) - xx) + "px",
                                "top": (boardPosition.top + ((AppConstants.variables.boardCellHeight - 1) * yy)) + "px"
                            });
                            $(tile_li).data({
                                resizeLeft: ((AppConstants.variables.boardCellWidth * xx) - xx),
                                resizeTop: ((AppConstants.variables.boardCellHeight - 1) * yy)
                            });
                        } else {
                            $(tile_li).css({
                                "width": (AppConstants.variables.boardCellHeight - 2) + "px",
                                "height": (AppConstants.variables.boardCellHeight - 2) + "px",
                                "left": (boardPosition.left + ((AppConstants.variables.boardCellWidth - 1) * xx)) + "px",
                                "top": (boardPosition.top + ((AppConstants.variables.boardCellHeight - 1) * yy)) + "px"
                            });
                            $(tile_li).data({
                                resizeLeft: ((AppConstants.variables.boardCellWidth - 1) * xx),
                                resizeTop: ((AppConstants.variables.boardCellHeight - 1) * yy)
                            });
                        }
                    }
                }
                var cellData = BoardModel.getData(xx, yy);
                if (cellData.weightText != "") {
                    var tile_span = BaseUI.create("span", {
                        "class": AppConstants.styleClasses.boardPanel_bonusText,
                        "draggable": false
                    });
                    if (cellData.weightText == "3L" || cellData.weightText == "3W") {
                        $(tile_span).css({
                            color: "#ffffff"
                        });
                    }
                    $(tile_span).html(cellData.weightText).appendTo(tile_li);
                    if (AppConstants.variables.handheldDevice) {
                        if (!AppConstants.variables.showNumberBoard) {
                            $(tile_span).css("visibility", "hidden");
                        }
                    } else {
                        if (AppConstants.variables.showNumberBoard) {
                            if (cellData.chr != "") {
                                $(tile_span).css("visibility", "visible");
                            } else {
                                $(tile_span).css("visibility", "visible");
                            }
                        } else {
                            $(tile_span).css("visibility", "hidden");
                        }
                    }
                }
                if (cellData.chr != "") {
                    var color = AppConstants.styleClasses.tilePlayed;
                    if (MovesModel.lastMoveId() == cellData.moveId) {
                        color = AppConstants.styleClasses.tileLastPlayed;
                    }
                    Tile.init({
                        color: color,
                        code: cellData.chr,
                        inRack: false
                    });
                    var tile_div = RectTile.create(Tile);
                    $(tile_div).appendTo(tile_li).css({
                        "z-index": 200,
                        "left": "0px",
                        "top": "0px"
                    });
                    if (!AppConstants.variables.handheldDevice) {
                        $(tile_div).bind({
                            mousedown: function (event) {
                                if (event.which != undefined && event.which != 1) {
                                    return;
                                }
                                $(this).fadeOut(500, function () {
                                    $(this).fadeIn(500);
                                });
                            },
                            mouseup: function (event) {
                                if (event.which != undefined && event.which != 1) {
                                    return;
                                }
                                $(this).fadeIn(500);
                            },
                            mouseout: function (event) {
                                if (event.which != undefined && event.which != 1) {
                                    return;
                                }
                                $(this).fadeIn(500);
                            }
                        });
                    }
                }
                if (!AppConstants.variables.handheldDevice) {
                    if (cellData.chr == "") {
                        $(tile_li).bind({
                            mouseup: UIEvent.board.showArrow
                        });
                    }
                }
                $(tile_li).css({
                    "background-color": cellData.weightColor
                }).appendTo(this.boardDOM);
                if (cellData.chr == "") {
                    $(tile_li).droppable({
                        drop: UIEvent.board.tileDrop
                    });
                    $(tile_li).bind({
                        drop: UIEvent.board.tileDrop
                    });
                }
            }
        }
        if (!AppConstants.variables.handheldDevice) {
            var gameBoardKeyInput = BaseUI.create("input", {
                "id": this.ids.hiddenInputBox,
                "type": "text",
                "style": {
                    "position": "absolute",
                    "left": "-1000px"
                }
            });
            $(gameBoardKeyInput).appendTo(this.boardDOM).bind({
                keyup: UIEvent.board.inputKeyUp
            });
            $(gameBoardKeyInput).on("focus", function (e) {
                var pos = $("#" + BoardPanel.ids.cellArrow).parent().position();
                $(this).css({
                    top: pos.top
                });
            });
            $(this.boardDOM).bind({
                mousedown: function (event) {
                    if (event.which == 3) {
                        ContextMenu.flush();
                        ContextMenu.addItem({
                            "caption": "Recall Tiles",
                            "action": "RECALL"
                        });
                        ContextMenu.addItem({
                            "caption": "Refresh",
                            "action": "REFRESH"
                        });
                        ContextMenu.addItem({
                            "caption": (AppConstants.variables.showNumberBoard) ? "Plain Board" : "Numbered Board",
                            "action": "TOGGLENUMBER"
                        });
                        ContextMenu.show(event);
                    }
                }
            });
        }
    },
    autoDrop: function () {},
    keyUpTileRemove: function () {
        var obj = $("#" + BoardPanel.ids.cellArrow).parent();
        var cell = BoardPanel.getTileContainerIdToXY(obj.attr("id"));
        var prevCell = null;
        if (obj.data("arrowId") == 1) {
            prevCell = BoardModel.getHorizontalEmptyCell(cell.x, cell.y, -1, true);
        } else {
            if (obj.data("arrowId") == 2) {
                prevCell = BoardModel.getVerticalEmptyCell(cell.x, cell.y, -1, true);
            }
        }
        if (prevCell != null) {
            RackModel.addToRack(BoardModel.getData(prevCell.x, prevCell.y).chr);
            RackPanel.addToRack(BoardModel.getData(prevCell.x, prevCell.y).chr);
            BoardModel.setData(prevCell.x, prevCell.y, "", false);
            $("#" + BoardPanel.ids.boardCell + "_" + prevCell.x + "_" + prevCell.y).find("." + AppConstants.styleClasses.tileRack).remove();
            if (!(cell.x == prevCell.x && cell.y == prevCell.y)) {
                var diff = 0;
                if (cell.x == prevCell.x) {
                    diff = prevCell.y - cell.y;
                } else {
                    diff = prevCell.x - cell.x;
                }
                BoardPanel.arrowShift(diff);
            }
            $("#" + BoardPanel.ids.boardCell + "_" + prevCell.x + "_" + prevCell.y).droppable({
                disabled: false,
                drop: UIEvent.board.tileDrop
            });
        }
        RackPanel.updateScore(BoardModel.getTempScore());
        if (GameInfoModel.myTurn) {
            if (RackModel.rackString.length < RackModel.originalRackString.length) {
                ActionPanel.change(ActionPanel.type.TURN_AND_TILEPLACED);
            } else {
                ActionPanel.change(ActionPanel.type.TURN_AND_IDEAL);
            }
        }
    },
    keyUpTileDrop: function (str, isRed) {
        var obj = $("#" + BoardPanel.ids.cellArrow).parent();
        var cell = BoardPanel.getTileContainerIdToXY(obj.attr("id"));
        if (!BoardModel.canAddCellData(cell.x, cell.y)) {
            return;
        }
        if (isRed) {
            str = str.toLowerCase();
        }
        BoardModel.setData(cell.x, cell.y, str, true);
        Tile.init({
            color: AppConstants.styleClasses.tileRack,
            code: str,
            inRack: false
        });
        var tile_div = RectTile.create(Tile);
        $(tile_div).appendTo(obj).position({
            of: obj
        }).css({
            left: 0,
            top: 0
        }).draggable({
            revert: "invalid",
            zIndex: 2700
        });
        $(obj).droppable({
            disabled: true
        });
        RackModel.deleteFromRack(str);
        RackPanel.deleteFromRack(str);
        BoardPanel.arrowShift(1);
        RackPanel.updateScore(BoardModel.getTempScore());
        if (GameInfoModel.myTurn) {
            if (RackModel.rackString.length < RackModel.originalRackString.length) {
                ActionPanel.change(ActionPanel.type.TURN_AND_TILEPLACED);
            } else {
                ActionPanel.change(ActionPanel.type.TURN_AND_IDEAL);
            }
        }
    },
    getTileContainerIdToXY: function (obId) {
        var curCell = obId.split("_");
        if (curCell[0] != BoardPanel.ids.boardCell) {
            return {
                x: -1,
                y: -1
            };
        }
        return {
            x: parseInt(curCell[1]),
            y: parseInt(curCell[2])
        };
    },
    arrowShift: function (dir) {
        if ($("#" + BoardPanel.ids.cellArrow).parent().data("arrowId") == 1) {
            this.arrowMoveHorizontal(dir);
        } else {
            this.arrowMoveVertical(dir);
        }
    },
    arrowMoveHorizontal: function (direction) {
        if ($("#" + BoardPanel.ids.cellArrow).parent().data("arrowId") == 1) {
            var cell = this.getTileContainerIdToXY($("#" + BoardPanel.ids.cellArrow).parent().attr("id"));
            var nextCell = BoardModel.getHorizontalEmptyCell(parseInt(cell.x), parseInt(cell.y), direction);
            if (nextCell != null) {
                var nextCellId = this.ids.boardCell + "_" + nextCell.x + "_" + nextCell.y;
                if ($("#" + nextCellId).length > 0) {
                    $("#" + nextCellId).trigger("mouseup");
                }
            }
        } else {
            $("#" + BoardPanel.ids.cellArrow).parent().data({
                arrowId: 0
            });
            $("#" + BoardPanel.ids.cellArrow).parent().trigger("mouseup");
        }
    },
    arrowMoveVertical: function (direction) {
        if ($("#" + BoardPanel.ids.cellArrow).parent().data("arrowId") == 2) {
            var cell = this.getTileContainerIdToXY($("#" + BoardPanel.ids.cellArrow).parent().attr("id"));
            var nextCell = BoardModel.getVerticalEmptyCell(parseInt(cell.x), parseInt(cell.y), direction);
            if (nextCell != null) {
                var nextCellId = this.ids.boardCell + "_" + nextCell.x + "_" + nextCell.y;
                if ($("#" + nextCellId).length > 0) {
                    $("#" + nextCellId).data({
                        arrowId: 1
                    });
                    $("#" + nextCellId).trigger("mouseup");
                }
            }
        } else {
            $("#" + BoardPanel.ids.cellArrow).parent().data({
                arrowId: 1
            });
            $("#" + BoardPanel.ids.cellArrow).parent().trigger("mouseup");
        }
    },
    toggleCellWeightText: function () {
        if (AppConstants.variables.showNumberBoard) {
            $("." + AppConstants.styleClasses.boardPanel_bonusText).css({
                "visibility": "hidden"
            });
            AppConstants.variables.showNumberBoard = false;
        } else {
            $("." + AppConstants.styleClasses.boardPanel_bonusText).css({
                "visibility": "visible"
            });
            AppConstants.variables.showNumberBoard = true;
        }
        $("#" + BoardPanel.ids.hiddenInputBox).focus();
    },
    isCellWeightTextShowing: function () {
        return AppConstants.variables.showNumberBoard;
    },
    recall: function () {
        BlankTilePopup.hide();
        var tempData = BoardModel.recall();
        for (var index = 0; index < tempData.length; index++) {
            $("#" + this.ids.boardCell + "_" + tempData[index].x + "_" + tempData[index].y).find("." + AppConstants.styleClasses.tileRack).remove();
            $("#" + this.ids.boardCell + "_" + tempData[index].x + "_" + tempData[index].y).droppable({
                disabled: false
            });
        }
    },
    destroy: function () {
        $("#" + AppConstants.elmIds.boardPanel).empty();
    }
};
var ContextMenu = {
    showing: false,
    items: [],
    addItem: function (data) {
        this.items.push(data);
    },
    show: function (event) {
        this.hide();
        var conMenu = BaseUI.create("ul", {
            "id": "ContextMenu",
            "class": AppConstants.styleClasses.contextMenu,
            "style": {
                "left": event.pageX + "px",
                "top": event.pageY + "px"
            }
        });
        for (var i = 0; i < this.items.length; i++) {
            var itemLi = BaseUI.create("li");
            $(itemLi).html(this.items[i].caption).data({
                action: this.items[i].action
            }).bind({
                mousedown: function () {
                    ContextMenu.doAction($(this).data("action"));
                }
            }).appendTo(conMenu);
        }
        $("#" + AppConstants.elmIds.gameContainer).append(conMenu);
        this.showing = true;
    },
    hide: function () {
        $("#ContextMenu").remove();
        this.showing = false;
    },
    flush: function () {
        this.items = [];
    },
    doAction: function (action) {
        switch (action) {
        case "REFRESH":
            ActionPanel.doAction({
                action: "REFRESH"
            });
            break;
        case "RECALL":
            ActionPanel.doAction({
                action: "RECALL"
            });
            break;
        case "TOGGLENUMBER":
            BoardPanel.toggleCellWeightText();
            break;
        }
    }
};
var ActionPanel = {
    type: {
        TURN_AND_IDEAL: 0,
        TURN_AND_TILEPLACED: 1,
        NOTURN: 2,
        GAME_OVER: 3
    },
    buttons: [
        [{
            caption: "Shuffle",
            action: "SHUFFLE",
            "class": "shuffleButton",
            side: "LEFT",
            form: "MEDIUM"
        }, {
            caption: "Swap",
            action: "SWAP",
            "class": "swapButton",
            side: "RIGHT",
            form: "SMALL"
        }, {
            caption: "Pass",
            action: "PASS",
            "class": "passButton",
            side: "RIGHT",
            form: "SMALL"
        }],
        [{
            caption: "Undo",
            action: "RECALL",
            "class": "recallButton",
            side: "LEFT",
            form: "SMALL"
        }, {
            caption: "Swap",
            action: "SWAP",
            "class": "swapButton",
            side: "LEFT",
            form: "SMALL"
        }, {
            caption: "Play",
            action: "PLAY",
            "class": "playButton",
            side: "RIGHT",
            form: "MEDIUM"
        }],
        [{
            caption: "Refr",
            action: "REFRESH",
            "class": "refreshButton",
            side: "LEFT",
            form: "SMALL"
        }, {
            caption: "Shuf",
            action: "SHUFFLE",
            "class": "shuffleButton",
            side: "LEFT",
            form: "SMALL"
        }, {
            caption: "Next",
            action: "NEXT",
            "class": "nextButton",
            side: "RIGHT",
            form: "MEDIUM"
        }],
        [{
            caption: "Remt",
            action: "REMATCH",
            "class": "rematchButton",
            side: "LEFT",
            form: "SMALL"
        }, {
            caption: "Anlz",
            action: "ANALYZE",
            "class": "analyzeButton",
            side: "LEFT",
            form: "SMALL"
        }, {
            caption: "Next",
            action: "NEXT",
            "class": "nextButton",
            side: "RIGHT",
            form: "MEDIUM"
        }]
    ],
    status: 0,
    create: function () {
        if (AppConstants.variables.siteCode == "FB") {
            ActionPanel.buttons[3] = [{
                caption: "Rematch",
                action: "REMATCH",
                "class": "rematchButton",
                side: "LEFT",
                form: "MEDIUM"
            }, {
                caption: "Next",
                action: "NEXT",
                "class": "nextButton",
                side: "RIGHT",
                form: "MEDIUM"
            }];
        }
        $("#" + AppConstants.elmIds.actionPanel).addClass(AppConstants.styleClasses.actionPanel);
        $("#" + AppConstants.elmIds.leftActionPanel).addClass(AppConstants.styleClasses.actionPanel_leftActionPanel);
        $("#" + AppConstants.elmIds.rackPanel).addClass(AppConstants.styleClasses.rackPanel);
        $("#" + AppConstants.elmIds.rightActionPanel).addClass(AppConstants.styleClasses.actionPanel_rightActionPanel);
        this.status = this.decideStatus();
        for (var index = 0; index < this.buttons[this.status].length; index++) {
            var button = this.createButton(this.buttons[this.status][index]);
            if (this.buttons[this.status][index].side == "LEFT") {
                $("#" + AppConstants.elmIds.leftActionPanel).append(button);
            } else {
                if (this.buttons[this.status][index].side == "RIGHT") {
                    if (index == 2) {
                        $(button).css({
                            "margin-right": "0"
                        });
                    }
                    $("#" + AppConstants.elmIds.rightActionPanel).append(button);
                }
            }
        }
    },
    decideStatus: function () {
        if (GameInfoModel.status == "F") {
            return this.type.GAME_OVER;
        } else {
            if (!GameInfoModel.myTurn) {
                return this.type.NOTURN;
            } else {
                return this.type.TURN_AND_IDEAL;
            }
        }
    },
    change: function (st) {
        if (st == undefined) {
            st = this.decideStatus();
        }
        if (this.status == st) {
            return;
        }
        this.status = st;
        $("#" + AppConstants.elmIds.leftActionPanel).empty();
        $("#" + AppConstants.elmIds.rightActionPanel).empty();
        for (var index = 0; index < this.buttons[this.status].length; index++) {
            var button = this.createButton(this.buttons[this.status][index]);
            if (this.buttons[this.status][index].side == "LEFT") {
                $("#" + AppConstants.elmIds.leftActionPanel).append(button);
            } else {
                if (this.buttons[this.status][index].side == "RIGHT") {
                    if (index == 2) {
                        $(button).css({
                            "margin-right": "0"
                        });
                    }
                    $("#" + AppConstants.elmIds.rightActionPanel).append(button);
                }
            }
        }
    },
    createButton: function (bttnObj) {
        var bttn = null;
        if (bttnObj["form"] == "MEDIUM") {
            bttn = BaseUI.create("div", {
                "class": AppConstants.styleClasses.actionPanel_greyButton
            });
            $(bttn).html('<div class="' + bttnObj["class"] + '">' + bttnObj.caption + "</div>").bind({
                click: function () {
                    ActionPanel.doAction({
                        action: bttnObj.action
                    });
                },
                mousedown: function () {
                    $(this).attr("class", "pressButton");
                },
                mouseup: function () {
                    $(this).attr("class", AppConstants.styleClasses.actionPanel_greyButton);
                },
                mouseenter: function () {
                    $(this).find("div").attr({
                        "class": bttnObj["class"] + "Over"
                    });
                },
                mouseleave: function () {
                    $(this).attr("class", AppConstants.styleClasses.actionPanel_greyButton);
                    $(this).find("div").attr({
                        "class": bttnObj["class"]
                    });
                }
            });
        } else {
            if (bttnObj["form"] == "SMALL") {
                bttn = BaseUI.create("span", {
                    "class": "smallGreyButton"
                });
                $(bttn).html(bttnObj.caption).bind({
                    mousedown: function () {
                        $(this).attr("class", "smallGreyButtonPressed");
                    },
                    mouseup: function () {
                        $(this).attr("class", "smallGreyButton");
                        ActionPanel.doAction({
                            action: bttnObj.action
                        });
                    },
                    mouseenter: function () {},
                    mouseleave: function () {
                        $(this).attr("class", "smallGreyButton");
                    }
                });
            }
        }
        if (bttnObj.action == "SHUFFLE") {
            $(bttn).bind({
                dblclick: function () {
                    ActionPanel.doAction({
                        action: "SORT"
                    });
                }
            });
        }
        return bttn;
    },
    doAction: function (obj) {
        switch (obj.action) {
        case "SORT":
            RackPanel.sort();
            break;
        case "ANALYZE":
            ActivityIndicator.show("Loading, ");
            window.location.href = AppConstants.variables.callURL.analyze + "&gid=" + AppConstants.variables.gameId + "&pid=" + AppConstants.variables.gamePid;
            break;
        case "SHUFFLE":
            RackPanel.shuffle();
            break;
        case "HOME":
            UIEvent.board.playHome();
            break;
        case "REMATCH":
            if (AppConstants.variables.siteCode == "FB") {
                var oppUids = [];
                for (var index = 1; index <= PlayersModel.getPlayersCount(); index++) {
                    if (PlayersModel.getUidByPid(index) != PlayersModel.getMyUid()) {
                        oppUids.push(PlayersModel.getUidByPid(index));
                    }
                }
                var myid = PlayersModel.getMyUid();
                var myInfo = PlayersModel.getInfoByUid(myid);
                var name = [];
                for (var i = 0; i < PlayersModel.getPlayersCount(); i++) {
                    if (PlayersModel.playersInfo["_" + PlayersModel.playersUid[i]].name != myInfo.name) {
                        name.push(PlayersModel.playersInfo["_" + PlayersModel.playersUid[i]].name);
                    }
                }
                name = name.join(",");
                top.location.href = AppConstants.variables.urlRematchNodes[1] + "?action=rematch&with=" + oppUids.join(",") + "&name=" + name + "&rematch=1&game_id=" + AppConstants.variables.gameId;
            } else {
                UIEvent.board.playRematch();
            }
            break;
        case "NEXT":
            UIEvent.board.playNextGame();
            break;
        case "CHALLENGE":
            if (!GameInfoModel.myTurn) {
                return false;
            }
            var wordObj = BoardModel.getLastPlayedWords();
            var words = [];
            for (var i = 0; i < wordObj.length; i++) {
                for (var j = 0; j < wordObj[i].length; j++) {
                    var s = "";
                    for (var k = 0; k < wordObj[i][j].length; k++) {
                        s += wordObj[i][j][k].chr;
                    }
                    var found = false;
                    for (var l = 0; l < words.length; l++) {
                        if (s == words[l]) {
                            found = true;
                        }
                    }
                    if (!found) {
                        words.push(s);
                    }
                }
            }
            PopUpBox.open({
                title: "Challenge Word",
                body: "Are you sure you wish to challenge the last turn? The words you will challenge are: " + words.join(", "),
                proceed: {
                    text: "OK",
                    execute: this.doAction,
                    param: {
                        action: "CONFIRMCHALLENGE"
                    }
                },
                abort: {
                    text: "Cancel"
                }
            });
            break;
        case "CONFIRMCHALLENGE":
            UIEvent.board.playChallenge();
            break;
        case "RECALL":
            BoardPanel.recall();
            RackPanel.recall();
            ActionPanel.change();
            break;
        case "REFRESH":
            UIEvent.board.playRefresh();
            break;
        case "PLAY":
            if (AppConstants.variables.askBeforePlay) {
                PopUpBox.open({
                    title: "Play Move",
                    body: "Are you sure you wish to play this move?",
                    proceed: {
                        text: "OK",
                        execute: this.doAction,
                        param: {
                            action: "CONFIRMPLAY"
                        }
                    },
                    abort: {
                        text: "Cancel"
                    }
                });
            } else {
                UIEvent.board.playMove();
            }
            break;
        case "CONFIRMPLAY":
            UIEvent.board.playMove();
            break;
        case "PASS":
            PopUpBox.open({
                title: "Pass Turn",
                body: "Are you sure you wish to pass your turn and score zero points?",
                proceed: {
                    text: "OK",
                    execute: this.doAction,
                    param: {
                        action: "CONFIRMPASS"
                    }
                },
                abort: {
                    text: "Cancel"
                }
            });
            break;
        case "CONFIRMPASS":
            UIEvent.board.playPass();
            break;
        case "SWAP":
            var swapBody = BaseUI.create("div");
            var topDiv = BaseUI.create("div");
            $(topDiv).html('<div style="padding-bottom:5px;">Swapping tiles will cost you a turn. Click on the tiles you wish to swap:</div>');
            var topRackDOM = BaseUI.create("ul", {
                "id": "swapPopupTopRack",
                "class": AppConstants.styleClasses.rackPanel
            });
            for (var i = 0; i < 8; i++) {
                if (RackModel.getValueByOriginalPosition(i) == "") {
                    break;
                }
                var rackLI = BaseUI.create("li", {
                    "id": "swapTopTile_" + i
                });
                $(rackLI).data({
                    pos: i
                });
                Tile.init({
                    color: AppConstants.styleClasses.tileRack,
                    code: RackModel.getValueByOriginalPosition(i),
                    inRack: true
                });
                var rackItem = RectTile.create(Tile);
                $(rackItem).data({
                    chr: RackModel.getValueByOriginalPosition(i)
                }).appendTo(rackLI).bind({
                    mouseup: function () {
                        var pos = $(this).parent().data("pos");
                        var data = "";
                        if ($(this).parent().parent().attr("id") == "swapPopupBottomRack") {
                            $(this).effect("puff", [], 100, function () {
                                $(this).appendTo($("#swapTopTile_" + pos)).show("puff", [], 100);
                            });
                            data += $("#swapPopupBottomRack").data("str");
                            data = data.replace($(this).data("chr"), "");
                            $("#swapPopupBottomRack").data("str", data);
                        } else {
                            $(this).hide("puff", [], 100, function () {
                                $(this).appendTo($("#swapBottomTile_" + pos)).show("puff", [], 100);
                            });
                            data += $("#swapPopupBottomRack").data("str");
                            data += $(this).data("chr");
                        }
                        $("#swapPopupBottomRack").data("str", data.replace("undefined", ""));
                    }
                });
                $(rackLI).appendTo(topRackDOM);
            }
            $(topDiv).append(topRackDOM);
            var bottomDiv = BaseUI.create("div", {
                "style": {
                    "clear": "both",
                    "margin-top": "40px"
                }
            });
            $(bottomDiv).html('<div style="padding-bottom:5px;">I wish to swap:</div>');
            var bottomRackDOM = BaseUI.create("ul", {
                "id": "swapPopupBottomRack",
                "class": AppConstants.styleClasses.rackPanel
            });
            for (var i = 0; i < 8; i++) {
                if (RackModel.getValueByOriginalPosition(i) == "") {
                    break;
                }
                var rackLI = BaseUI.create("li", {
                    "id": "swapBottomTile_" + i
                });
                $(rackLI).data({
                    pos: i
                });
                $(rackLI).appendTo(bottomRackDOM);
            }
            $(bottomDiv).append(bottomRackDOM);
            $(swapBody).append(topDiv).append(bottomDiv);
            PopUpBox.open({
                title: "Swap Tiles",
                body: swapBody,
                proceed: {
                    text: "OK",
                    execute: this.doAction,
                    param: {
                        action: "CONFIRMSWAP"
                    }
                },
                abort: {
                    text: "Cancel"
                }
            });
            var restPos = RackModel.getTilePosPlacedInBoard();
            if (restPos.length > 0) {
                for (var kl = 0; kl < restPos.length; kl++) {
                    $("#swapTopTile_" + restPos[kl] + " .tileRack").trigger("mouseup");
                }
            }
            break;
        case "CONFIRMSWAP":
            BoardPanel.recall();
            UIEvent.board.playSwap($("#swapPopupBottomRack").data("str"));
            break;
        }
    },
    destroy: function () {
        $("#" + AppConstants.elmIds.leftActionPanel).empty();
        $("#" + AppConstants.elmIds.rightActionPanel).empty();
    }
};
var RackPanel = {
    rackDOM: null,
    ids: {
        tile: "RackSlot",
        score: "RackScore"
    },
    create: function () {
        var rackLI = null;
        this.rackDOM = $("#" + AppConstants.elmIds.rackPanel);
        for (var i = 0; i < 8; i++) {
            rackLI = BaseUI.create("li", {
                "id": RackPanel.ids.tile + "_" + i
            });
            $(rackLI).appendTo(this.rackDOM);
            if (AppConstants.variables.analyzeGame == 0) {
                var rackItemDisplayText = RackModel.getValueByPosition(i);
            } else {
                var rackItemDisplayText = "";
            }
            if (rackItemDisplayText != "") {
                Tile.init({
                    color: AppConstants.styleClasses.tileRack,
                    code: rackItemDisplayText,
                    inRack: true
                });
                var rackItem = RectTile.create(Tile);
                $(rackItem).appendTo(rackLI);
                if (!AppConstants.variables.handheldDevice) {
                    $(rackItem).delay(50 * i).show("scale", {
                        from: {
                            width: 0,
                            height: 0
                        }
                    }, 300);
                }
            } else {
                $(rackLI).html("");
            }
            $(rackLI).droppable({
                disabled: false,
                drop: UIEvent.board.tileDrop
            });
        }
        rackLI = BaseUI.create("li", {
            "id": RackPanel.ids.tile + "_" + i
        });
        $(rackLI).html("").appendTo(this.rackDOM);
        if (AppConstants.variables.analyzeGame == 0) {
            $(rackLI).droppable({
                disabled: false,
                drop: UIEvent.board.tileDrop
            });
            $("#" + AppConstants.elmIds.rackPanel + " ." + AppConstants.styleClasses.tileRack).draggable({
                revert: "invalid",
                zIndex: 2700
            }).bind({
                click: RackPanel.autoClick
            });
        }
        if (AppConstants.variables.handheldDevice && !AppConstants.variables.androidDevice) {
            $("#" + AppConstants.elmIds.rackPanel + " ." + AppConstants.styleClasses.tileRack).draggable({
                cursorAt: {
                    top: 70
                },
                scroll: false
            });
        } else {
            if (AppConstants.variables.androidDevice) {
                $("#" + AppConstants.elmIds.rackPanel + " ." + AppConstants.styleClasses.tileRack).draggable({
                    scroll: false
                });
            }
        }
    },
    autoClick: function (evt) {
        if ($(this).parent().parent().attr("id") != AppConstants.elmIds.rackPanel) {
            return;
        }
        var pos = BoardModel.getNextValidPosition();
        if (pos.nextX != null && pos.nextY != null && AppConstants.variables.autoTilePlace) {
            var obj = {
                draggable: $(this)
            };
            $("#" + BoardPanel.ids.boardCell + "_" + pos.nextX + "_" + pos.nextY).trigger("drop", [obj, true]);
        }
    },
    updateScore: function (scoreText) {
        $("#" + RackPanel.ids.score).html(scoreText);
        var valScore = $("#score").html();
        if (valScore == null) {
            $("#" + RackPanel.ids.tile + "_" + 8).append('<span id="score" class="tempScore" style="padding-left:7px;">' + scoreText + "</span>");
        } else {
            $("#score").html(scoreText);
        }
    },
    sort: function () {
        RackModel.sort();
        for (var i = 0; i < 8; i++) {
            var rackLI = $("#" + AppConstants.elmIds.rackPanel).find("#" + RackPanel.ids.tile + "_" + i);
            rackLI.empty();
            var rackItemDisplayText = RackModel.getValueByPosition(i);
            if (rackItemDisplayText != "") {
                Tile.init({
                    color: AppConstants.styleClasses.tileRack,
                    code: rackItemDisplayText,
                    inRack: true
                });
                var rackItem = RectTile.create(Tile);
                $(rackItem).draggable({
                    revert: "invalid",
                    zIndex: 2700
                }).bind({
                    click: RackPanel.autoClick
                }).appendTo(rackLI).delay(30 * i);
            } else {
                $(rackLI).droppable({
                    disabled: false,
                    drop: UIEvent.board.tileDrop
                });
            }
        }
        $("#" + AppConstants.elmIds.rackPanel).find("#" + RackPanel.ids.tile + "_" + 8).empty();
    },
    shuffle: function () {
        RackModel.shuffle();
        for (var i = 0; i < 8; i++) {
            var rackLI = $("#" + AppConstants.elmIds.rackPanel).find("#" + RackPanel.ids.tile + "_" + i);
            rackLI.empty();
            var rackItemDisplayText = RackModel.getValueByPosition(i);
            if (rackItemDisplayText != "") {
                Tile.init({
                    color: AppConstants.styleClasses.tileRack,
                    code: rackItemDisplayText,
                    inRack: true
                });
                var rackItem = RectTile.create(Tile);
                $(rackItem).draggable({
                    revert: "invalid",
                    zIndex: 2700
                }).bind({
                    click: RackPanel.autoClick
                }).appendTo(rackLI).delay(30 * i);
            } else {
                $(rackLI).droppable({
                    disabled: false,
                    drop: UIEvent.board.tileDrop
                });
            }
        }
        $("#" + AppConstants.elmIds.rackPanel).find("#" + RackPanel.ids.tile + "_" + 8).empty();
    },
    addToRack: function (ch) {
        for (var i = 0; i < 8; i++) {
            var tile = $("#" + RackPanel.ids.tile + "_" + i).find("." + AppConstants.styleClasses.tileRack);
            if ($(tile).data("tile") == undefined) {
                Tile.init({
                    color: AppConstants.styleClasses.tileRack,
                    code: ch,
                    inRack: true
                });
                var rackItem = RectTile.create(Tile);
                $(rackItem).appendTo($("#" + RackPanel.ids.tile + "_" + i)).delay(50 * i).show("scale", {
                    from: {
                        width: 0,
                        height: 0
                    }
                }, 300);
                if (AppConstants.variables.analyzeGame == 0) {
                    $(rackItem).draggable({
                        revert: "invalid",
                        zIndex: 2700
                    }).bind({
                        click: RackPanel.autoClick
                    }).droppable({
                        disable: true
                    });
                }
                if (AppConstants.variables.handheldDevice && !AppConstants.variables.androidDevice) {
                    $(rackItem).draggable({
                        cursorAt: {
                            top: 70
                        },
                        scroll: false
                    });
                } else {
                    if (AppConstants.variables.androidDevice) {
                        $(rackItem).draggable({
                            scroll: false
                        });
                    }
                }
                break;
            }
        }
    },
    deleteFromRack: function (ch) {
        Tile.init({
            color: AppConstants.styleClasses.tileRack,
            code: ch,
            inRack: true
        });
        for (var i = 0; i < 8; i++) {
            var tile = $("#" + RackPanel.ids.tile + "_" + i).find("." + AppConstants.styleClasses.tileRack);
            if ($(tile).data("tile") != undefined && Tile.isSame($(tile).data("tile"))) {
                $(tile).parent().droppable({
                    disabled: false,
                    drop: UIEvent.board.tileDrop
                });
                $(tile).remove();
                break;
            }
        }
    },
    recall: function () {
        RackModel.recall();
        this.destroy();
        this.create();
    },
    destroy: function () {
        $("#" + AppConstants.elmIds.rackPanel).empty();
    }
};
var OptionMenu = {
    submenuCreated: false,
    ids: {
        menuContainer: "menuContainer",
        optionMenuPopup: "optionMenuPopup"
    },
    create: function () {
        $("#" + AppConstants.elmIds.optionMenu).addClass(AppConstants.styleClasses.rightPanel_optionMenu).append('<span class="caption">Game Options</span><span class="backIcon"></span>').bind({
            mouseenter: function () {
                if (OptionMenu.submenuCreated) {
                    return;
                }
                var left = $(this).position().left + 14;
                var top = $(this).position().top + $(this).outerHeight(true);
                OptionMenu.openSubmenu(left, top);
                OptionMenu.submenuCreated = true;
                $(this).addClass(AppConstants.styleClasses.optionMenu_over);
                $("#" + AppConstants.elmIds.optionMenu + " .backIcon").attr({
                    "class": "backIconOver"
                });
            }
        });
        $("#" + AppConstants.elmIds.menuConatiner).css({
            "height": "100%"
        }).bind({
            mouseleave: function () {
                OptionMenu.hideSubmenu();
            }
        });
    },
    openSubmenu: function (left, top) {
        var submenuItems = [{
            caption: "Refresh Game",
            action: "REFRESH"
        }, {
            caption: "View Tiles Left",
            action: "VIEWTILES"
        },
        null,
        {
            caption: "Examine",
            action: "EXAMINE"
        }, {
            caption: "Two Letter Words",
            action: "TWOLETTERWORD"
        },
        null];
        if (MovesModel.length() < 4) {
            submenuItems.push({
                caption: "Delete Game",
                action: "DELETEGAME"
            });
        } else {
            if (MovesModel.length() >= 4) {
                submenuItems.push({
                    caption: "Resign Game",
                    action: "RESIGNGAME"
                });
            }
        }
        submenuItems.push(null);
        submenuItems.push({
            caption: "Feedback",
            action: "FEEDBACK"
        });
        if (AppConstants.variables.analyzeGame == 1) {
            var submenuItems = [{
                caption: "Refresh Game",
                action: "REFRESH"
            }, {
                caption: "View Tiles Left",
                action: "VIEWTILES"
            },
            null,
            {
                caption: "Two Letter Words",
                action: "TWOLETTERWORD"
            },
            null,
            {
                caption: "Feedback",
                action: "FEEDBACK"
            }];
        }
        var ulDom = BaseUI.create("ul", {
            "id": this.ids.optionMenuPopup
        });
        for (var index = 0; index < submenuItems.length; index++) {
            var li = BaseUI.create("li");
            if (submenuItems[index] == null) {
                $(li).addClass("seperator");
            } else {
                $(li).data({
                    action: submenuItems[index].action
                }).bind({
                    mousedown: function () {
                        OptionMenu.doAction({
                            action: $(this).data("action")
                        });
                    }
                }).html(submenuItems[index].caption);
                if (index == submenuItems.length - 1) {
                    $(li).addClass("lastSubmenu");
                }
            }
            $(li).appendTo(ulDom);
        }
        $(ulDom).css({
            left: left + "px",
            top: top + "px"
        }).appendTo("#" + AppConstants.elmIds.menuConatiner);
    },
    hideSubmenu: function () {
        $("#" + OptionMenu.ids.optionMenuPopup).remove();
        OptionMenu.submenuCreated = false;
        $("#" + AppConstants.elmIds.optionMenu).removeClass(AppConstants.styleClasses.optionMenu_over);
        $("#" + AppConstants.elmIds.optionMenu + " .backIconOver").attr({
            "class": "backIcon"
        });
    },
    doAction: function (obj) {
        OptionMenu.hideSubmenu();
        switch (obj.action) {
        case "TWOLETTERWORD":
            TwoLetterWordsPanel.open();
            break;
        case "FEEDBACK":
            sendfeedback_fromboard();
            break;
        case "REFRESH":
            ActionPanel.doAction({
                action: "REFRESH"
            });
            break;
        case "VIEWTILES":
            TilesLeftPanel.open();
            break;
        case "EXAMINE":
            ExaminePopup.open();
            break;
        case "DELETEGAME":
            if (MovesModel.length() > 4) {
                ActivityIndicator.show("Not possible, please click here.", true);
            } else {
                PopUpBox.open({
                    title: "Delete Game",
                    body: "Are you sure you wish to delete this game? Please remember that deletion is not possible if 4 or more moves have been played.",
                    proceed: {
                        text: "Yes",
                        execute: OptionMenu.doAction,
                        param: {
                            action: "CONFIRMDELETE"
                        }
                    },
                    abort: {
                        text: "No"
                    }
                });
            }
            break;
        case "CONFIRMDELETE":
            UIEvent.board.playDelete();
            break;
        case "RESIGNGAME":
            PopUpBox.open({
                title: "Resign Game",
                body: "Are you sure you wish to resign this game? It will count as a loss and your stats will be affected.",
                proceed: {
                    text: "Yes",
                    execute: OptionMenu.doAction,
                    param: {
                        action: "CONFIRMRESIGN"
                    }
                },
                abort: {
                    text: "No"
                }
            });
            break;
        case "CONFIRMRESIGN":
            UIEvent.board.playResign();
        }
    },
    destroy: function () {
        OptionMenu.hideSubmenu();
        $("#" + AppConstants.elmIds.optionMenu).empty();
        ExaminePopup.hide();
    }
};
var ExaminePopup = {
    showing: false,
    curPosition: null,
    open: function () {
        var dom = '<div id="examinePopup">' + '<div class="header"><span>Examine</span><a href="javascript:void(0)" onclick="ExaminePopup.hide();return false;" style="margin-top:7px;">X</a></div>' + '<div class="body">' + '<div><div class="first button" onclick="ExaminePopup.doAction(\'FIRST\');"></div><div class="previous button" onclick="ExaminePopup.doAction(\'PREVIOUS\');"></div>' + '<div class="next button" onclick="ExaminePopup.doAction(\'NEXT\');"></div><div class="last button" onclick="ExaminePopup.doAction(\'LAST\');"></div>' + '</div><div class="msg">&nbsp;</div></div></div>';
        var left = $("#" + AppConstants.elmIds.optionMenu).position().left - 6;
        var top = $("#" + AppConstants.elmIds.optionMenu).position().top + 6;
        $(dom).css({
            left: left + "px",
            top: top + "px"
        }).appendTo($("#" + AppConstants.elmIds.gameContainer));
        this.curPosition = MovesModel.lastMoveId();
        this.showing = true;
    },
    hide: function () {
        this.showing = false;
        $("#examinePopup").remove();
        this.curPosition = MovesModel.lastMoveId();
        for (var yy = 0; yy < AppConstants.variables.boardColCount; yy++) {
            for (var xx = 0; xx < AppConstants.variables.boardRowCount; xx++) {
                $("#" + BoardPanel.ids.boardCell + "_" + xx + "_" + yy + " div").show();
            }
        }
    },
    doAction: function (action) {
        var msg = "";
        switch (action) {
        case "FIRST":
            this.curPosition = 1;
            break;
        case "LAST":
            this.curPosition = MovesModel.lastMoveId();
            break;
        case "PREVIOUS":
            this.curPosition--;
            if (this.curPosition < 1) {
                this.curPosition = 0;
                msg = "no more moves";
            }
            break;
        case "NEXT":
            this.curPosition++;
            if (this.curPosition > MovesModel.lastMoveId()) {
                this.curPosition = MovesModel.lastMoveId();
                msg = "this was the last move";
            }
            break;
        }
        var moveData = MovesModel.getData((this.curPosition == MovesModel.lastMoveId()) ? this.curPosition - 1 : this.curPosition);
        if (moveData == undefined) {
            return;
        }
        if (moveData.moveType == "PASS") {
            msg += "turn was passed in this move";
        } else {
            if (moveData.moveType == "SWAP") {
                msg += "tiles were swapped";
            } else {
                if (moveData.moveType == "CHALLENGE") {
                    msg += "this move was challenged";
                } else {
                    msg += "&nbsp;";
                    for (var yy = 0; yy < AppConstants.variables.boardColCount; yy++) {
                        for (var xx = 0; xx < AppConstants.variables.boardRowCount; xx++) {
                            var moveBoardData = BoardModel.getData(xx, yy);
                            if (moveBoardData.moveId <= this.curPosition) {
                                $("#" + BoardPanel.ids.boardCell + "_" + xx + "_" + yy + " div").show();
                            } else {
                                $("#" + BoardPanel.ids.boardCell + "_" + xx + "_" + yy + " div").hide();
                            }
                        }
                    }
                }
            }
        }
        $("#examinePopup .msg").html(msg);
    }
};
var PlayerList = {
    create: function () {
        var playerList = $("#" + AppConstants.elmIds.playerList);
        $(playerList).addClass(AppConstants.styleClasses.playerList);
        for (var pid = 1; pid <= PlayersModel.getPlayersCount(); pid++) {
            $(playerList).append(this.addUser(pid));
        }
        $("." + AppConstants.styleClasses.playerList_turnArrow).show("pulsate", [], 500);
    },
    addUser: function (pid) {
        var divRow = BaseUI.create("div");
        var userNameLink = BaseUI.create("a");
        $(userNameLink).css({
            "overflow": "hidden",
            "width": "120px"
        }).html(PlayersModel.getInfoByPid(pid)["name"] + " (" + FeedDataModel.rating[pid] + ")").bind({
            click: function () {
                if (AppConstants.variables.siteCode == "Email") {
                    if (StatModel.hasData(PlayersModel.getUidByPid(pid))) {
                        StatPanel.draw(StatModel.getData(PlayersModel.getUidByPid(pid)));
                    } else {
                        GameController.postRequest({
                            action: "USERSTAT",
                            statUid: PlayersModel.getUidByPid(pid),
                            name: PlayersModel.getInfoByPid(pid)["name"]
                        });
                    }
                }
            }
        }).appendTo(divRow);
        if (AppConstants.variables.siteCode == "FB") {
            $(userNameLink).attr({
                "href": AppConstants.variables.userStatURL + PlayersModel.getUidByPid(pid),
                "target": "_blank"
            });
        }
        ToolTip.addEvent(userNameLink, PlayersModel.getInfoByPid(pid)["name"] + " has " + PlayersModel.getInfoByPid(pid)["rackLength"] + " tiles");
        if (GameInfoModel.isProUser(PlayersModel.getUidByPid(pid))) {
            var userProLink = BaseUI.create("a");
            $(userProLink).html("PRO").appendTo(divRow);
            $(userProLink).addClass(AppConstants.styleClasses.playerList_userPro).attr({
                "href": "http://www.lexulous.com/subscribe",
                "target": "_blank"
            });
        } else {} if (PlayersModel.getInfoByPid(pid)["online"]) {
            var userOnlineLink = BaseUI.create("a", {
                "class": AppConstants.styleClasses.playerList_userOnline
            });
            $(userOnlineLink).appendTo(divRow);
            ToolTip.addEvent(userOnlineLink, "Online");
        }
        var userScoreLink = BaseUI.create("a");
        $(userScoreLink).html(PlayersModel.getInfoByPid(pid)["score"]).appendTo(divRow);
        if (GameInfoModel.turnUid == PlayersModel.getUidByPid(pid)) {
            $(userNameLink).addClass(AppConstants.styleClasses.playerList_userNameTurn);
            $(userScoreLink).addClass(AppConstants.styleClasses.playerList_userScoreTurn);
            var turnArrowDiv = BaseUI.create("div", {
                "class": AppConstants.styleClasses.playerList_turnArrow
            });
            $(turnArrowDiv).appendTo(divRow);
        } else {
            $(userNameLink).addClass(AppConstants.styleClasses.playerList_userName);
            $(userScoreLink).addClass(AppConstants.styleClasses.playerList_userScore);
        }
        return divRow;
    },
    destroy: function () {
        $("#" + AppConstants.elmIds.playerList).empty();
    }
};
var InfoPanel = {
    create: function () {
        var infoPanelDiv = $("#" + AppConstants.elmIds.infoPanel);
        var text = "";
        var chadded = false;
        if (GameInfoModel.status == "F") {
            text += "Game Over: ";
            if (GameInfoModel.winner == -1) {
                text += "Drawn";
            } else {
                text += GameInfoModel.winner + " WINS! ";
            }
            if (MovesModel.getLastData() != undefined) {
                if (MovesModel.getLastData()["moveType"] == "PASS") {
                    text += "Turn passed by " + ((PlayersModel.getMyUid() == MovesModel.getLastData()["uid"]) ? "you" : PlayersModel.getInfoByUid(MovesModel.getLastData()["uid"])["name"]) + ", ";
                } else {
                    text += 'Last move was <a href="javascript:void(0)" class="playWord" onclick="UIEvent.dicPanel.outerDic.mouseup(event, \'' + MovesModel.getLastData()["word"] + "'); return false;\">" + MovesModel.getLastData()["word"] + "</a> by " + ((PlayersModel.getMyUid() == MovesModel.getLastData()["uid"]) ? "you" : PlayersModel.getInfoByUid(MovesModel.getLastData()["uid"])["name"]) + " for " + MovesModel.getLastData()["score"] + " points, ";
                }
            }
            text += '<a href="javascript:void(0)" class="challengeLink" onclick="UIEvent.board.playRematch();return false;">[Rematch]</a>';
        } else {
            if (!GameInfoModel.myTurn) {
                text += PlayersModel.getInfoByUid(GameInfoModel.turnUid).name + "'s turn, ";
            }
            if (MovesModel.getLastData() != undefined) {
                switch (MovesModel.getLastData()["moveType"]) {
                case "MOVE":
                    if (PlayersModel.getMyUid() == MovesModel.getLastData()["uid"]) {
                        text += "you";
                    } else {
                        text += PlayersModel.getInfoByUid(MovesModel.getLastData()["uid"])["name"];
                    }
                    text += ' played <a href="javascript:void(0)" class="playWord" onclick="UIEvent.dicPanel.outerDic.mouseup(event, \'' + MovesModel.getLastData()["word"] + "'); return false;\">" + MovesModel.getLastData()["word"] + "</a> (" + MovesModel.getLastData()["score"] + ")";
                    break;
                case "PASS":
                    if (PlayersModel.getMyUid() == MovesModel.getLastData()["uid"]) {
                        text += "you passed your turn";
                    } else {
                        text += PlayersModel.getInfoByUid(MovesModel.getLastData()["uid"])["name"] + " has passed turn";
                    }
                    break;
                case "SWAP":
                    if (PlayersModel.getMyUid() == MovesModel.getLastData()["uid"]) {
                        text += "you swapped tiles";
                    } else {
                        text += PlayersModel.getInfoByUid(MovesModel.getLastData()["uid"])["name"] + " has swapped tiles";
                    }
                    break;
                case "CHALLENGE":
                    if (MovesModel.getLastData()["word"] == " ") {
                        if (PlayersModel.getMyUid() == MovesModel.getLastData()["uid"]) {
                            text += "your challenge was incorrect!";
                        } else {
                            text += "Your turn, your move " + MovesModel.getPrevLastData()["word"] + " was challenged and was found valid";
                        }
                    } else {
                        if (MovesModel.getLastData()["word"] != " ") {
                            if (PlayersModel.getMyUid() != MovesModel.getLastData()["uid"]) {
                                text += "Your turn, your challenge was correct!";
                            } else {
                                text += PlayersModel.getInfoByUid(MovesModel.getLastData()["uid"])["name"] + "'s move " + MovesModel.getLastData()["word"] + " was challenged and was found invalid";
                            }
                        }
                    }
                    break;
                }
            }
            text += (text == "") ? "" : " - ";
            text += '<a href="javascript:void(0)" class="tilesLeft" onclick="TilesLeftPanel.open(); return false;">' + GameInfoModel.tilesInBag + " tiles left</a>.";
            if (GameInfoModel.gameType == "C" && GameInfoModel.myTurn && MovesModel.getLastData() != undefined && MovesModel.getLastData()["moveType"] != "CHALLENGE") {
                text += ' <a id="challengeLinkId" href="javascript:void(0)" class="challengeLink" onclick="ActionPanel.doAction({action:\'CHALLENGE\'});return false;">Challenge</a>';
                chadded = true;
            }
        }
        $(infoPanelDiv).addClass(AppConstants.styleClasses.infoPanel).html(text);
        if (chadded) {
            ToolTip.addEvent("#challengeLinkId", "?");
        }
        return this.infoPanelDiv;
    },
    destroy: function () {
        $("#" + AppConstants.elmIds.infoPanel).empty();
    }
};
var CombinedPanel = {
    currentSelection: 0,
    create: function () {
        var combinedPanelDiv = $("#" + AppConstants.elmIds.combinedPanel);
        $(combinedPanelDiv).addClass(AppConstants.styleClasses.combinedPanel);
        var headingDiv = BaseUI.create("div", {
            "class": AppConstants.styleClasses.combinedPanel_heading
        });
        var bodyDiv = BaseUI.create("div", {
            "class": AppConstants.styleClasses.combinedPanel_body
        });
        var chatLink = BaseUI.create("a", {
            "id": "chatMenuId",
            "class": AppConstants.styleClasses.heading_menuActive
        });
        $(chatLink).html("Chat").bind({
            mouseup: function () {
                if (CombinedPanel.currentSelection == 0 && AppConstants.variables.showChat) {
                    var pos = $("." + AppConstants.styleClasses.combinedPanel_heading).position();
                    var height = $("." + AppConstants.styleClasses.combinedPanel_heading).outerHeight();
                    $("#chatSubmenu").css({
                        top: (pos.top + height)
                    }).show();
                    return;
                }
                $(this).removeClass(AppConstants.styleClasses.heading_menuInactive).addClass(AppConstants.styleClasses.heading_menuActive);
                $(dicLink).removeClass(AppConstants.styleClasses.heading_menuActive).addClass(AppConstants.styleClasses.heading_menuInactive);
                ChatPanel.show();
                DicPanel.hide();
                CombinedPanel.currentSelection = 0;
            }
        }).appendTo(headingDiv);
        if (AppConstants.variables.showChat) {
            $(chatLink).html('Chat&nbsp;<img src="http://dgy15uhpz7zbk.cloudfront.net/board/images/down_arrow.png" alt="" />');
        }
        var dicLink = BaseUI.create("a", {
            "class": AppConstants.styleClasses.heading_menuInactive
        });
        $(dicLink).html("Dictionary").bind({
            mouseup: function () {
                if (CombinedPanel.currentSelection == 1) {
                    return;
                }
                $(this).removeClass(AppConstants.styleClasses.heading_menuInactive).addClass(AppConstants.styleClasses.heading_menuActive);
                $(chatLink).removeClass(AppConstants.styleClasses.heading_menuActive).addClass(AppConstants.styleClasses.heading_menuInactive);
                ChatPanel.hide();
                DicPanel.show();
                CombinedPanel.currentSelection = 1;
            },
            mouseenter: function () {
                $("#chatSubmenu").hide();
            }
        }).appendTo(headingDiv);
        var moveLink = BaseUI.create("a", {
            "class": AppConstants.styleClasses.heading_menuInactive
        });
        $(moveLink).html("Moves").bind({
            mouseup: function () {
                MovesPanel.open();
            },
            mouseenter: function () {
                $("#chatSubmenu").hide();
            }
        }).appendTo(headingDiv);
        $(headingDiv).appendTo(combinedPanelDiv).bind({
            mouseleave: function () {
                $("#chatSubmenu").hide();
            }
        });
        var conMenu = BaseUI.create("ul", {
            "id": "chatSubmenu",
            "class": AppConstants.styleClasses.contextMenu
        });
        var itemLi = BaseUI.create("li");
        $(itemLi).html("Mute Chat").bind({
            mousedown: function () {
                if (AppConstants.variables.showChat) {
                    PopUpBox.open({
                        title: "Chat",
                        body: "Are you sure you wish to mute chat? This action can't be undone for this game.",
                        proceed: {
                            text: "OK",
                            execute: function () {
                                AppConstants.variables.showChat = false;
                                $("#chatMenuId").html("Chat");
                                GameController.postRequest({
                                    action: "MUTECHAT"
                                });
                            },
                            param: {}
                        },
                        abort: {
                            text: "Cancel"
                        }
                    });
                }
                $("#chatSubmenu").hide();
            }
        }).appendTo(conMenu);
        $(conMenu).hide().appendTo(headingDiv);
        $(bodyDiv).append(ChatPanel.create()).appendTo(combinedPanelDiv);
        return combinedPanelDiv;
    },
    analyze: function () {
        var combinedPanelDiv = $("#" + AppConstants.elmIds.combinedPanel);
        var headingDiv = $(".heading");
        $(headingDiv).css({
            "padding": "5px 0 0 0"
        });
        $(headingDiv).css({
            "height": "25px"
        });
        var bodyDiv = $(".body");
        AnalyzeExaminePopup.open();
        headingDiv.html("");
        var previousLink = BaseUI.create("a", {
            "id": "prevAnaId",
            "class": "menuActive_left",
            "style": {
                "margin": "0",
                "display": "none",
                "float": "left",
                "margin-left": "5px"
            }
        });
        $(previousLink).bind({
            mouseup: function () {
                AnalyzeExaminePopup.doAction("PREVIOUS");
            }
        }).appendTo(headingDiv);
        var anaLink = BaseUI.create("a", {
            "id": "prevAnaTxt",
            "style": {
                "line-height": "18px",
                "margin": "0",
                "text-decoration": "none",
                "font-size": "16px",
                "float": "left",
                "width": "174px"
            }
        });
        $(anaLink).html("").appendTo(headingDiv);
        var nextLink = BaseUI.create("a", {
            "id": "nextAnaId",
            "class": "menuActive_right",
            "style": {
                "margin": "0",
                "display": "none",
                "float": "right",
                "margin-right": "5px"
            }
        });
        $(nextLink).bind({
            mouseup: function () {
                AnalyzeExaminePopup.doAction("NEXT");
            }
        }).appendTo(headingDiv);
        ChatPanel.destroy();
        DicPanel.destroy();
        var anaBody = BaseUI.create("div", {
            "id": "anaBodyDiv"
        });
        $(anaBody).css({
            "min-height": "284px"
        });
        $(anaBody).appendTo(bodyDiv);
    },
    destroy: function () {
        ChatPanel.destroy();
        DicPanel.destroy();
        $("#" + AppConstants.elmIds.combinedPanel).empty();
        CombinedPanel.currentSelection = 0;
    }
};
var ChatPanel = {
    created: false,
    lastMsgUid: null,
    msgIndex: 0,
    create: function () {
        var chatPanelDiv = BaseUI.create("div", {
            "class": AppConstants.styleClasses.chatPanel
        });
        var preChatBodyDiv = BaseUI.create("div", {
            "id": "preChatBodyDiv",
            "style": {
                "padding-top": "10px"
            }
        });
        var chatBodyDiv = BaseUI.create("div", {
            "class": AppConstants.styleClasses.chatPanel_chatBody
        });
        if (PlayersModel.getPlayersCount() == 4) {
            $(chatBodyDiv).css({
                height: "215px"
            });
        } else {
            if (PlayersModel.getPlayersCount() == 3) {
                $(chatBodyDiv).css({
                    height: "236px"
                });
            } else {
                $(chatBodyDiv).css({
                    height: "257px"
                });
            }
        }
        for (var index = 0; index < ChatModel.length(); index++) {
            var msgObj = ChatModel.getData(index);
            if (msgObj.uid == null) {
                continue;
            }
            this.addChatMsg(msgObj, chatBodyDiv);
        }
        var chatInputDiv = BaseUI.create("div", {
            "class": AppConstants.styleClasses.chatPanel_chatInput
        });
        var inputTextBox = BaseUI.create("input", {
            "type": "text",
            "class": AppConstants.styleClasses.chatPanel_inputBox
        });
        $(inputTextBox).val("Type reply here...").bind({
            click: function () {
                if ($(this).val() == "Type reply here...") {
                    $(this).val("");
                    $(this).css({
                        color: "#777"
                    });
                }
            },
            focusout: function (event) {
                if ($(this).val() == "") {
                    $(this).val("Type reply here...");
                    $(this).css({
                        color: "#777"
                    });
                }
            },
            keydown: function (event) {
                $(this).css({
                    color: "#333"
                });
            },
            keyup: function (event) {
                if ($(this).val() != "Type reply here..." && $(this).val() != "") {} else {} if (event.keyCode == 13 && $(this).val() != "Type reply here...") {
                    UIEvent.chatPanel.send(event, $(this).val());
                    $(this).val("");
                    $(this).css({
                        color: "#777"
                    });
                }
            }
        }).appendTo(chatInputDiv);
        var sendButtonLink = BaseUI.create("a", {
            "class": AppConstants.styleClasses.chatPanel_sendButton
        });
        $(sendButtonLink).html("Send").bind({
            mousedown: function () {
                $(this).attr("class", "sendButtonPressed");
            },
            mouseup: function (event) {
                if ($(inputTextBox).val() != "Type reply here...") {
                    UIEvent.chatPanel.send(event, $(inputTextBox).val());
                    $(inputTextBox).css({
                        color: "#777"
                    });
                }
                $(inputTextBox).val("").focus();
                $(this).attr("class", AppConstants.styleClasses.chatPanel_sendButton);
            },
            mouseleave: function () {
                $(this).attr("class", AppConstants.styleClasses.chatPanel_sendButton);
            }
        }).appendTo(chatInputDiv);
        $(chatPanelDiv).append(chatBodyDiv).append(chatInputDiv);
        $(chatBodyDiv).slimscroll({
            height: $(chatBodyDiv).css("height") + "px",
            allowPageScroll: false,
            railVisible: true,
            start: "bottom",
            alwaysVisible: true
        });
        this.created = true;
        $(preChatBodyDiv).append(chatPanelDiv);
        return preChatBodyDiv;
    },
    addChatMsg: function (msgObj, container) {
        var text = "";
        if (msgObj.uid == PlayersModel.getMyUid()) {
            if (this.lastMsgUid == msgObj.uid) {
                text += '<p style="margin:0 0 0 0;" onmousemove="$(\'#chatDate' + this.msgIndex + "').show();\" onmouseout=\"$('#chatDate" + this.msgIndex + '\').hide();"><span style="padding-top:2px;font-size:' + AppConstants.variables.msgSize + 'px">' + this.addEmoticon(msgObj.msg) + "</span></p>";
            } else {
                this.msgIndex++;
                text += '<p style="margin:5px 0 0 0;" onmousemove="$(\'#chatDate' + this.msgIndex + "').show();\" onmouseout=\"$('#chatDate" + this.msgIndex + '\').hide();"><span class="senderName">Me:</span> <span class="chatDate" style="display:none;" id="chatDate' + this.msgIndex + '">(' + this.formatDate(msgObj.date) + ")</span><br />";
                text += '<span style="padding-top:2px;font-size:' + AppConstants.variables.msgSize + 'px">' + this.addEmoticon(msgObj.msg) + "</span></p>";
            }
        } else {
            if (this.lastMsgUid == msgObj.uid) {
                text += '<p style="margin:0 0 0 13px;" onmousemove="$(\'#chatDate' + this.msgIndex + "').show();\" onmouseout=\"$('#chatDate" + this.msgIndex + '\').hide();"><span style="padding-top:2px;font-size:' + AppConstants.variables.msgSize + 'px">' + this.addEmoticon(msgObj.msg) + "</span></p>";
            } else {
                this.msgIndex++;
                text += '<div style="margin:5px 0 0 0;" onmousemove="$(\'#chatDate' + this.msgIndex + "').show();\" onmouseout=\"$('#chatDate" + this.msgIndex + '\').hide();"><span class="opponentChatIcon1"></span>' + '<p style="margin:0 0 0 13px;">' + '<span class="senderName">' + PlayersModel.getInfoByUid(msgObj.uid).name + ":</span>" + ' <span class="chatDate" id="chatDate' + this.msgIndex + '" style="display:none;">(' + this.formatDate(msgObj.date) + ")</span><br />" + '<span style="padding-top:2px;font-size:' + AppConstants.variables.msgSize + 'px">' + this.addEmoticon(msgObj.msg) + "</span></p></div>";
            }
        }
        this.lastMsgUid = msgObj.uid;
        if (container != undefined) {
            $(container).append(text);
        } else {
            $("." + AppConstants.styleClasses.chatPanel_chatBody).append(text);
        }
    },
    cliclimgName: "",
    imageClickCheck: function (data) {
        var split_name = data.split("_");
        var pidInFile = split_name[2];
        if (pidInFile == AppConstants.variables.gamePid) {
            $("#" + data.replace(".", "")).trigger("click");
        } else {
            $("#" + data.replace(".", "")).trigger("click");
        }
    },
    addEmoticon: function (text) {
        var len = text.length;
        var msg_img_path = "https://d35zhpgb1mza1j.cloudfront.net/fblex_chat_image/";
        if ((text.substr(0, 2) == "**") && (text.substr(len - 2, len - 1) == "**")) {
            var split_msg = text.split("**");
            var f_name = split_msg[1];
            var fnSplit = f_name.split("_");
            var msgIndex = f_name.replace(".", "");
            var specs = FeedDataModel.msgSpecsArr[msgIndex];
            var specArr = specs.split("|");
            var height = specArr[1];
            var width = specArr[0];
            var height_padding = (150 - height) / 2 + "px";
            var width_padding = (150 - width) / 2 + "px";
            var padding = height_padding + " " + width_padding;
            var return_text = '<div style="height:' + height + "px;width:" + width + "px;background-color:black;padding:" + padding + ';cursor:pointer;"><div style="height:' + height + "px;width:" + width + 'px;"><img src="' + msg_img_path + f_name + '" style="height:100%;width:100%;" id="img_' + f_name.replace(".", "") + '" onclick ="ChatPanel.imageClickCheck(\'' + f_name + '\');" style="cursor:pointer;" /></div></div>';
            return_text += (fnSplit[2] != AppConstants.variables.gamePid) ? '<a href="javascript:void(0);" onclick="javascript:ChatPanel.reportImage(\'' + f_name + '\');" style="float:right;color:red;font-size:8px;margin-top:-10px;display:none;" id="report_' + f_name.replace(".", "") + '">Report</a>' : "";
            var a_link = '<a id="' + f_name.replace(".", "") + '" href="' + msg_img_path + f_name.replace("_blur", "") + '" data-lightbox="' + f_name + '"></a>';
            if ($("#" + f_name.replace(".", "")).length == 0) {
                $("body").append(a_link);
            }
            return return_text;
        }
        var s = "#@115#";
        text = text.replace(">:0", s);
        text = text.replace(">:-0", s);
        text = text.replace(">:o", s);
        text = text.replace(">:-o", s);
        var l = "#@108#";
        text = text.replace("3:)", l);
        text = text.replace("3:-)", l);
        var i = "#@105#";
        text = text.replace(">:(", i);
        text = text.replace(">:-(", i);
        var m = "#@109#";
        text = text.replace("0:)", m);
        text = text.replace("0:-)", m);
        var a = "#@97#";
        text = text.replace(":-)", a);
        text = text.replace(":)", a);
        text = text.replace(":]", a);
        text = text.replace("=)", a);
        var b = "#@98#";
        text = text.replace(":-(", b);
        text = text.replace(":(", b);
        text = text.replace(":[", b);
        text = text.replace("=(", b);
        var c = "#@99#";
        text = text.replace(":-P", c);
        text = text.replace(":P", c);
        text = text.replace(":-p", c);
        text = text.replace(":p", c);
        text = text.replace("=p", c);
        var d = "#@100#";
        text = text.replace(":-D", d);
        text = text.replace(":D", d);
        text = text.replace("=D", d);
        var e = "#@101#";
        text = text.replace(":-0", e);
        text = text.replace(":0", e);
        text = text.replace(":-o", e);
        text = text.replace(":o", e);
        var f = "#@102#";
        text = text.replace(";-)", f);
        text = text.replace(";)", f);
        var g = "#@103#";
        text = text.replace("8-)", g);
        text = text.replace("8)", g);
        text = text.replace("B-)", g);
        text = text.replace("B)", g);
        var h = "#@104#";
        text = text.replace("8-|", h);
        text = text.replace("8|", h);
        text = text.replace("B-|", h);
        text = text.replace("B|", h);
        var k = "#@107#";
        text = text.replace(":'(", k);
        var n = "#@110#";
        text = text.replace(":-*", n);
        text = text.replace(":*", n);
        var o = "#@111#";
        text = text.replace("<3", o);
        var p = "#@112#";
        text = text.replace("^-^", p);
        var q = "#@113#";
        text = text.replace("-_-", q);
        var r = "#@114#";
        text = text.replace("o.0", r);
        text = text.replace("0.o", r);
        var t = "#@116#";
        text = text.replace(":v", t);
        var u = "#@117#";
        text = text.replace(":3", u);
        var v = "#@118#";
        text = text.replace("(y)", v);
        text = text.replace("(Y)", v);
        var j = "#@106#";
        text = text.replace(":-/", j);
        text = text.replace(":-", j);
        for (var i = 97; i <= 118; i++) {
            text = text.replace(eval("/" + "#@" + i + "#/g"), '<img src="' + AppConstants.variables.emoUrl + "/" + String.fromCharCode(i) + '.png" />');
        }
        return text;
    },
    formatDate: function (dateStr) {
        var spaceSplit = dateStr.split(" ");
        var daySplit = spaceSplit[0].split("-");
        return parseInt(daySplit[0]) + " " + daySplit[1] + " at " + spaceSplit[1];
    },
    getServerDate: function () {
        var month = ["Jan", "Feb", "March", "April", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        var now = new Date();
        var str = now.getDate() + "-" + month[now.getMonth()] + "-" + now.getFullYear() + " " + now.getHours() + ":" + now.getMinutes() + " GMT";
        return str;
    },
    scrollToBottom: function () {
        $("." + AppConstants.styleClasses.chatPanel_chatBody).slimscroll({
            scroll: ($("." + AppConstants.styleClasses.chatPanel_chatBody).prop("scrollHeight") - 257) + "px"
        });
    },
    show: function () {
        if (!this.created) {
            $("#" + AppConstants.elmIds.combinedPanel).find("." + AppConstants.styleClasses.combinedPanel_body).append(this.create());
        } else {
            $("#preChatBodyDiv").show();
        }
    },
    hide: function () {
        $("#preChatBodyDiv").hide();
    },
    destroy: function () {
        $("." + AppConstants.styleClasses.chatPanel).remove();
        this.created = false;
        this.lastMsgUid = null;
    }
};
var DicPanel = {
    ids: {
        outerDic: "dicPanelOuterSearch",
        innerDic: "dicPanelInnerSearch",
        wordResult: "dicPanelwordCheckResult"
    },
    created: false,
    create: function () {
        var adjustDivHeight = 0;
        var dicPanelDiv = BaseUI.create("div", {
            "class": AppConstants.styleClasses.dicPanel
        });
        if (PlayersModel.getPlayersCount() == 4) {
            $(dicPanelDiv).css({
                height: "250px"
            });
            adjustDivHeight = 22;
        } else {
            if (PlayersModel.getPlayersCount() == 3) {
                $(dicPanelDiv).css({
                    height: "271px"
                });
                adjustDivHeight = 44;
            } else {
                $(dicPanelDiv).css({
                    height: "292px"
                });
                adjustDivHeight = 64;
            }
        }
        var dicSlotTop = this.createSlot({
            mainId: this.ids.outerDic,
            headTxt: "Encyclopedia",
            descTxt: "Find word meanings and see them used in sentences as well:",
            bttnTxt: "Go"
        });
        $(dicSlotTop).find("." + AppConstants.styleClasses.dicPanel_dicInputBox).bind({
            focusout: function (event) {
                var value = $.trim($(dicSlotTop).find("." + AppConstants.styleClasses.dicPanel_dicInputBox).val());
                if (value == "") {} else {}
            },
            keyup: function (event) {
                var value = $.trim($(dicSlotTop).find("." + AppConstants.styleClasses.dicPanel_dicInputBox).val());
                if (value != "") {} else {}
                UIEvent.dicPanel.outerDic.keyup(event, value);
            }
        });
        $(dicSlotTop).find("a").bind({
            mousedown: function (event) {
                $(this).attr("class", "sendButtonPressed");
            },
            mouseup: function (event) {
                $(this).attr("class", AppConstants.styleClasses.dicPanel_sendButton);
                UIEvent.dicPanel.outerDic.mouseup(event, $(dicSlotTop).find("." + AppConstants.styleClasses.dicPanel_dicInputBox).val());
            },
            mouseleave: function (event) {
                $(this).attr("class", AppConstants.styleClasses.dicPanel_sendButton);
            }
        });
        var dicSlotBot = this.createSlot({
            mainId: this.ids.innerDic,
            headTxt: "Game Dictionary",
            descTxt: "Check to see if a word is playable within the game or not:",
            bttnTxt: "Go"
        });
        $(dicSlotBot).find("." + AppConstants.styleClasses.dicPanel_dicInputBox).bind({
            focusout: function (event) {
                var value = $.trim($(dicSlotBot).find("." + AppConstants.styleClasses.dicPanel_dicInputBox).val());
                if (value == "") {} else {}
            },
            keyup: function (event) {
                var value = $.trim($(dicSlotBot).find("." + AppConstants.styleClasses.dicPanel_dicInputBox).val());
                if (value != "") {} else {}
                UIEvent.dicPanel.innerDic.keyup(event, value);
            }
        });
        $(dicSlotBot).find("a").bind({
            mousedown: function (event) {
                $(this).attr("class", "sendButtonPressed");
            },
            mouseup: function (event) {
                $(this).attr("class", AppConstants.styleClasses.dicPanel_sendButton);
                UIEvent.dicPanel.innerDic.mouseup(event, $(dicSlotBot).find("." + AppConstants.styleClasses.dicPanel_dicInputBox).val());
            },
            mouseleave: function (event) {
                $(this).attr("class", AppConstants.styleClasses.dicPanel_sendButton);
            }
        });
        var wordCheckResultDiv = BaseUI.create("div", {
            "id": this.ids.wordResult,
            "class": AppConstants.styleClasses.dicPanel_wordCheck
        });
        $(wordCheckResultDiv).html("&nbsp;").appendTo(dicSlotBot);
        $(dicSlotTop).append('<div style="clear:both;height:' + adjustDivHeight + 'px;"></div>');
        $(dicPanelDiv).append(dicSlotBot).append(dicSlotTop).append('<div class="footer">Proper nouns are not allowed</div>');
        if (GameInfoModel.gameType == "C") {
            $(dicPanelDiv).css({
                "visibility": "hidden"
            });
        }
        this.created = true;
        return dicPanelDiv;
    },
    createSlot: function (obj) {
        var dicSlot = BaseUI.create("div", {
            "id": obj.mainId,
            "class": AppConstants.styleClasses.dicPanel_dicSlot
        });
        $(dicSlot).append("<span>" + obj.headTxt + "</span>");
        $(dicSlot).append("<p>" + obj.descTxt + "</p>");
        var dicInputDiv = BaseUI.create("div", {
            "class": AppConstants.styleClasses.dicPanel_dicInput
        });
        var dicInputTextBox = BaseUI.create("input", {
            "class": AppConstants.styleClasses.dicPanel_dicInputBox
        });
        var sendButton = BaseUI.create("a", {
            "class": AppConstants.styleClasses.dicPanel_sendButton
        });
        $(sendButton).html(obj.bttnTxt);
        $(dicInputDiv).append(dicInputTextBox).append(sendButton).appendTo(dicSlot);
        return dicSlot;
    },
    updateWordCheckResult: function (result, msgText) {
        if (result) {
            $("#" + this.ids.wordResult).css({
                color: "#008222"
            }).html(msgText);
            $("#" + this.ids.innerDic).find("." + AppConstants.styleClasses.dicPanel_dicInputBox).val("");
        } else {
            $("#" + this.ids.wordResult).css({
                color: "#820000"
            }).html(msgText);
            $("#" + this.ids.innerDic).find("." + AppConstants.styleClasses.dicPanel_dicInputBox).focus();
        }
    },
    show: function () {
        if (!this.created) {
            $("#" + AppConstants.elmIds.combinedPanel).find("." + AppConstants.styleClasses.combinedPanel_body).append(this.create());
        } else {
            $("." + AppConstants.styleClasses.dicPanel).show();
        }
        $("#dicPanelInnerSearch").find(".dicInputBox").focus();
    },
    hide: function () {
        $("." + AppConstants.styleClasses.dicPanel).hide();
    },
    destroy: function () {
        $("." + AppConstants.styleClasses.dicPanel).remove();
        this.created = false;
    }
};
var MovesPanel = {
    open: function () {
        var divs = '<div class="movesPanel"><div class="header"><span>Moves List</span>';
        if (MovesModel.length() > 0 && AppConstants.variables.siteCode == "Email") {
            divs += '<a href="javascript:void(0)" class="send">send via mail</a>';
        } else {
            divs += "&nbsp;";
        }
        divs += '<a href="javascript:void(0)" class="close">X</a></div><div class="body">';
        var innerDivWidth = parseInt(100 / PlayersModel.getPlayersCount());
        for (var pl = 0; pl < PlayersModel.getPlayersCount(); pl++) {
            var plData = PlayersModel.getInfo(pl);
            var index = 1;
            var totalScore = 0;
            divs += '<div class="column" style="width:' + innerDivWidth + '%;"><ul style="padding-bottom:5px;"><li style="width:10%;text-align:center;color:#156df2;">#</li><li style="width:45%;color:#156df2;">' + plData.name + '</li><li style="width:25%;text-align:center;color:grey">move score</li><li style="width:20%;text-align:center;color:grey">total</li></ul>';
            var alertRowColor = "#d8e8f7";
            for (var mv = 0; mv < MovesModel.length(); mv++) {
                var mvData = MovesModel.getData(mv);
                if (mvData.uid == PlayersModel.getUidByPid(plData.pid)) {
                    var word = "";
                    if (mvData.moveType == "PASS") {
                        word = '<span style="color:#0066cc;">PASS</span>';
                    } else {
                        if (mvData.moveType == "SWAP") {
                            word = '<span style="color:#0066cc;">SWAP</span>';
                        } else {
                            if (mvData.moveType == "MOVE") {
                                word = '<span style="color:#000;">' + mvData.word + "</span>";
                            } else {
                                if (mvData.moveType == "CHALLENGE") {
                                    word = '<span style="color:#0066cc;">CHALLENGE</span>';
                                }
                            }
                        }
                    }
                    totalScore += parseInt(mvData.score);
                    divs += '<ul style="background:' + alertRowColor + '"><li style="width:10%;text-align:center;">' + index + '</li><li style="width:45%;"> ' + word + ' </li><li style="width:25%;text-align:center;"> ' + mvData.score + ' </li><li style="width:20%;text-align:center;"> ' + totalScore + "</li></ul>";
                    index++;
                    alertRowColor = (alertRowColor == "#d8e8f7") ? "#fff" : "#d8e8f7";
                }
            }
            divs += "</div>";
        }
        divs += "</div></div>";
        $("#" + AppConstants.elmIds.gameContainer).append(divs);
        $(".movesPanel").fadeIn();
        var left = $("#" + AppConstants.elmIds.gameContainer).position().left + ($("#" + AppConstants.elmIds.gameContainer).outerWidth(true) / 2) - ($(".movesPanel").outerWidth(true) / 2);
        var top = $("#" + AppConstants.elmIds.gameContainer).position().top + ($("#" + AppConstants.elmIds.gameContainer).outerHeight(true) / 2) - ($(".movesPanel").outerHeight(true) / 2);
        $(".movesPanel").draggable({
            handle: ".header",
            containment: "#" + AppConstants.elmIds.gameContainer
        }).css({
            left: left + "px",
            top: top + "px"
        });
        $(".movesPanel .header .close").bind({
            mousedown: function () {
                MovesPanel.hide();
                return false;
            }
        });
        $(".movesPanel .header .send").bind({
            mousedown: function () {
                var plData = {};
                for (var pl = 0; pl < PlayersModel.getPlayersCount(); pl++) {
                    plData[PlayersModel.getUidByPid(pl + 1)] = PlayersModel.getInfoByPid(pl + 1);
                }
                RequestController.postMoveMail({
                    "moveInfo": MovesModel.movesInfo,
                    "plInfo": plData,
                    "gameInfo": {
                        "gid": AppConstants.variables.gameId,
                        "dic": GameInfoModel.dic,
                        "type": GameInfoModel.gameType,
                        "myuid": PlayersModel.getMyUid(),
                        "status": GameInfoModel.status
                    }
                });
                MovesPanel.hide();
                return false;
            }
        });
    },
    hide: function () {
        $(".movesPanel").fadeOut(function () {
            $(this).remove();
        });
    }
};
var TilesLeftPanel = {
    open: function () {
        var moveLetters = BoardModel.getMoveLettersToString() + RackModel.getRackLettersToString();
        var divs = '<div class="tilesLeftPanel"><div class="header"><span>Tiles Left</span><a href="javascript:void(0)">X</a></div><div class="body">';
        var chkLength = 84;
        if (GameInfoModel.dic == "FR") {
            chkLength = 86;
        } else {
            if (GameInfoModel.dic == "IT") {
                chkLength = 104;
            }
        }
        if (moveLetters.length > chkLength) {
            divs += '<div class="empty">Not available if there are FEWER than 15 tiles left.</div>';
        } else {
            var list = {
                A: 9,
                B: 2,
                C: 2,
                D: 4,
                E: 12,
                F: 2,
                G: 3,
                H: 2,
                I: 9,
                J: 1,
                K: 1,
                L: 4,
                M: 2,
                N: 6,
                O: 8,
                P: 2,
                Q: 1,
                R: 6,
                S: 4,
                T: 6,
                U: 4,
                V: 2,
                W: 2,
                X: 1,
                Y: 2,
                Z: 1,
                "blank": 2
            };
            var vowel = "42";
            var conso = "56";
            if (GameInfoModel.dic == "FR") {
                list = {
                    A: 9,
                    B: 2,
                    C: 2,
                    D: 3,
                    E: 15,
                    F: 2,
                    G: 2,
                    H: 2,
                    I: 8,
                    J: 1,
                    K: 1,
                    L: 5,
                    M: 3,
                    N: 6,
                    O: 6,
                    P: 2,
                    Q: 1,
                    R: 6,
                    S: 6,
                    T: 6,
                    U: 6,
                    V: 2,
                    W: 1,
                    X: 1,
                    Y: 1,
                    Z: 1,
                    "blank": 2
                };
                vowel = "44";
                conso = "56";
            } else {
                if (GameInfoModel.dic == "IT") {
                    list = {
                        A: 14,
                        B: 3,
                        C: 6,
                        D: 3,
                        E: 11,
                        F: 3,
                        G: 2,
                        H: 2,
                        I: 12,
                        J: 0,
                        K: 0,
                        L: 5,
                        M: 5,
                        N: 5,
                        O: 15,
                        P: 3,
                        Q: 1,
                        R: 6,
                        S: 6,
                        T: 6,
                        U: 5,
                        V: 3,
                        W: 0,
                        X: 0,
                        Y: 0,
                        Z: 2,
                        "blank": 2
                    };
                    vowel = "57";
                    conso = "61";
                }
            }

            if(AppConstants.variables.isCustomBoard){
                var tilesCountArr = FeedDataModel.tileLeft.split("|");
                
                var list = {};
                var vowel = 0;
                var conso = 0;
                var blanks = 0;
                var vowelArr = ["a","e","i","o","u"];
                

                for(var key in tilesCountArr){
                    var data = tilesCountArr[key].split(",");
                    
                    if(vowelArr.indexOf(data[0]) !=-1){
                        list[data[0].toUpperCase()] = parseInt(data[1]);
                        vowel += parseInt(data[1]);
                    }else if(data[0]=="blank"){
                        list[data[0]] = parseInt(data[1]);
                        blanks += parseInt(data[1]);
                    }else{
                        list[data[0].toUpperCase()] = parseInt(data[1]);
                        conso += parseInt(data[1]);
                    }
                    
                }
            }else{
                var blanks = 2;
            }
            
            divs += '<div><span style="width:30%;color:#156df2;">'+vowel+' vowels</span><span style="width:40%;color:#019a34">'+conso+' consonants</span><span style="width:30%;color:#ce3b09">'+blanks+' blanks</span></div><ul>';
            blankCount = 0;
            for (var chr = 65; chr <= 91; chr++) {
                var count = 0;
                for (var index = 0; index < moveLetters.length; index++) {
                    if (moveLetters.charAt(index) == String.fromCharCode(chr)) {
                        count++;
                    } else {
                        if (moveLetters.charAt(index) == String.fromCharCode(chr + 32)) {
                            blankCount++;
                        }
                    }
                }
                for (var sub = 1; sub <= list[String.fromCharCode(chr)]; sub++) {
                    if (sub <= count) {
                        divs += '<li style="background:#949494;color:#cecece;">' + String.fromCharCode(chr) + "</li>";
                    } else {
                        divs += "<li>" + String.fromCharCode(chr) + "</li>";
                    }
                }
            }
            for (var bl = 1; bl <= list["blank"]; bl++) {
                if (bl <= blankCount) {
                    divs += '<li style="background:#949494;color:#cecece;">#</li>';
                } else {
                    divs += "<li>#</li>";
                }
            }
            divs += "</ul>";
        }
        divs += "</div></div>";
        $("#" + AppConstants.elmIds.gameContainer).append(divs);
        $(".tilesLeftPanel").fadeIn();
        var left = $("#" + AppConstants.elmIds.gameContainer).position().left + ($("#" + AppConstants.elmIds.gameContainer).outerWidth(true) / 2) - ($(".tilesLeftPanel").outerWidth(true) / 2);
        var top = $("#" + AppConstants.elmIds.gameContainer).position().top + ($("#" + AppConstants.elmIds.gameContainer).outerHeight(true) / 2) - ($(".tilesLeftPanel").outerHeight(true) / 2);
        $(".tilesLeftPanel").draggable({
            handle: ".header",
            containment: "#" + AppConstants.elmIds.gameContainer
        }).css({
            left: left + "px",
            top: top + "px"
        });
        $(".tilesLeftPanel .header a").bind({
            mousedown: function () {
                TilesLeftPanel.hide();
                return false;
            }
        });
    },
    hide: function () {
        $(".tilesLeftPanel").fadeOut(function () {
            $(this).remove();
        });
    }
};
var BlankTilePopup = {
    showing: false,
    open: function (posX, posY) {
        var blankInputUL = BaseUI.create("ul", {
            "class": AppConstants.styleClasses.blankTilePopup
        });
        $("#" + AppConstants.elmIds.boardPanel).append(blankInputUL);
        var position = $("#" + BoardPanel.ids.boardCell + "_" + posX + "_" + posY).position();
        var posLeft = position.left;
        var posTop = position.top;
        if (posY < 4) {
            posTop = position.top + $("#" + BoardPanel.ids.boardCell + "_" + posX + "_" + posY).outerHeight(true);
        } else {
            posTop = position.top - $(blankInputUL).outerHeight(true);
        }
        if (posX > 10) {
            posLeft = position.left - $(blankInputUL).outerWidth(true) + $("#" + BoardPanel.ids.boardCell + "_" + posX + "_" + posY).outerWidth(true);
        }
        $(blankInputUL).data({
            "posX": posX,
            "posY": posY
        }).css({
            left: posLeft + "px",
            top: posTop + "px"
        });
        for (var i = 65; i < 91; i++) {
            var charLI = BaseUI.create("li");
            $(charLI).html(String.fromCharCode(i)).data({
                value: String.fromCharCode(i)
            }).appendTo(blankInputUL);
        }
        $("." + AppConstants.styleClasses.blankTilePopup + " li").bind({
            mouseup: function (event) {
                $("#" + BoardPanel.ids.boardCell + "_" + posX + "_" + posY).find("." + AppConstants.styleClasses.tileRack).remove();
                BoardModel.setData(posX, posY, $(this).data("value").toLowerCase(), true);
                Tile.init({
                    color: AppConstants.styleClasses.tileRack,
                    code: $(this).data("value").toLowerCase(),
                    inRack: false
                });
                var tile_div = RectTile.create(Tile);
                $(tile_div).appendTo($("#" + BoardPanel.ids.boardCell + "_" + posX + "_" + posY)).draggable({
                    revert: "invalid",
                    zIndex: 2700
                }).position({
                    of: $("#" + BoardPanel.ids.boardCell + "_" + posX + "_" + posY),
                    offset: "0,0"
                });
                if (AppConstants.variables.handheldDevice && !AppConstants.variables.androidDevice) {
                    $(tile_div).draggable({
                        cursorAt: {
                            top: 70
                        },
                        scroll: false
                    });
                } else {
                    if (AppConstants.variables.androidDevice) {
                        $(tile_div).draggable({
                            scroll: false
                        });
                    }
                }
                $(blankInputUL).remove();
                RackPanel.updateScore(BoardModel.getTempScore());
                BlankTilePopup.showing = false;
            }
        });
        this.showing = true;
        $(RackPanel.rackDOM).bind({
            mousedown: function (event) {
                BlankTilePopup.hideAndUpdateRack();
            }
        });
    },
    hideAndUpdateRack: function () {
        if (BlankTilePopup.showing) {
            var popup = $("." + AppConstants.styleClasses.blankTilePopup);
            var x = popup.data("posX");
            var y = popup.data("posY");
            var tile = $("#" + BoardPanel.ids.boardCell + "_" + x + "_" + y).find("." + AppConstants.styleClasses.tileRack);
            RackModel.addToRack("a");
            RackPanel.addToRack($(tile).data("tile").displayText);
            BoardModel.setData(x, y, "", false);
            $(tile).remove();
            popup.remove();
            $("#" + BoardPanel.ids.boardCell + "_" + x + "_" + y).droppable({
                disabled: false,
                drop: UIEvent.board.tileDrop
            });
            $(RackPanel.rackDOM).unbind("mousedown");
            this.showing = false;
            if (GameInfoModel.myTurn) {
                if (RackModel.rackString.length < RackModel.originalRackString.length) {
                    ActionPanel.change(ActionPanel.type.TURN_AND_TILEPLACED);
                } else {
                    ActionPanel.change(ActionPanel.type.TURN_AND_IDEAL);
                }
            }
        }
    },
    hide: function () {
        if (BlankTilePopup.showing) {
            $("." + AppConstants.styleClasses.blankTilePopup).remove();
            this.showing = false;
            if (GameInfoModel.myTurn) {
                if (RackModel.rackString.length < RackModel.originalRackString.length) {
                    ActionPanel.change(ActionPanel.type.TURN_AND_TILEPLACED);
                } else {
                    ActionPanel.change(ActionPanel.type.TURN_AND_IDEAL);
                }
            }
        }
    }
};
var TwoLetterWordsPanel = {
    langType: {
        "SOW": "UK",
        "TWL": "US",
        "FR": "French",
        "IT": "Italian"
    },
    words: {
        "SOW": ["AA AB AD AE AG AH AI AL AM AN AR AS AT AW AX AY", "BA BE BI BO BY", "CH", "DA DE DI DO", "EA ED EE EF EH EL EM EN ER ES ET EX", "FA FE FY", "GI GO GU", "HA HE HI HM HO", "ID IF IN IO IS IT", "JA JO", "KA KI KO KY", "LA LI LO", "MA ME MI MM MO MU MY", "NA NE NO NU NY", "OB OD OE OF OH OI OM ON OO OP OR OS OU OW OX OY", "PA PE PI PO", "QI", "RE", "SH SI SO ST", "TA TE TI TO", "UG UH UM UN UP UR US UT", "WE WO", "XI XU", "YA YE YO YU", "ZA ZO"],
        "TWL": ["AA AB AD AE AG AH Al AL AM AN AR AS AT AW AX AY", "BA BE BI BO BY", "DE DO", "ED EF EH EL EM EN ER ES ET EX", "FA FE", "GO", "HA HE HI HM HO", "ID IF IN IS IT", "JO", "KA KI", "LA LI LO", "MA ME MI MM MO MU MY", "NA NE NO NU", "OD OE OF OH OI OM ON OP OR OS OW OX OY", "PA PE PI", "QI", "RE", "SH SI SO", "TA TI TO", "UH UM UN UP US UT", "WE WO", "XI XU", "YA YE YO", "ZA"],
        "FR": ["AA AH AI AN AS AU AY", "BI BU", "CA CE CI", "DA DE DO DU", "EH EN ES ET EU EX", "FA FI", "GO", "HA HE HI HO", "IF IL IN", "JE", "KA", "LA LE LI LU", "MA ME MI MU", "NA NE NI NO NU", "OC OH ON OR OS OU", "PI PU", "RA RE RI RU", "SA SE SI SU", "TA TE TU", "UN US UT", "VA VE VS VU", "WU", "XI"],
        "IT": ["AD AH AI AL AM AT", "BA BE BI BO BU", "CA CD CE CI CO CU CX", "DA DE DI DO DU", "EA ED EE EH EI EL EN EO ES ET EX", "FA FE FI FM FO FU", "GE GI GO", "HA HE HI HM HO", "ID IH IL IN IO", "KO", "LA LE LI LO LP", "MA ME MI MM MO MU", "NE NI NO NU", "OC OD OE OH OI OK ON OR", "PA PC PE PH PI PO PS PU", "QU", "RE RH RO", "SA SE SI SO SS ST SU", "TA TE TI TO TU TV", "UA UE UF UH UN UP UT", "VA VE VI VO VU", "WC", "XI", "ZA ZI"]
    },
    open: function () {
        var dom = '<div id="TwoLetterWordsPanel"><div class="header"><span>2 letter words (' + this.langType[GameInfoModel.dic] + ' Dictionary)</span><a href="javascript:void(0)">X</a></div><div class="body">';
        for (var index = 0; index < this.words[GameInfoModel.dic].length; index++) {
            dom += '<span><span style="color:#d22323;font-weight:bold;">' + this.words[GameInfoModel.dic][index][0] + "</span>" + this.words[GameInfoModel.dic][index].substr(1, this.words[GameInfoModel.dic][index].length) + "</span>";
            if (index != this.words[GameInfoModel.dic].length - 1) {
                dom += '<span class="block"> - </span>';
            }
        }
        dom += "</div></div>";
        $("#" + AppConstants.elmIds.gameContainer).append(dom);
        $("#TwoLetterWordsPanel").fadeIn();
        var left = $("#" + AppConstants.elmIds.gameContainer).position().left + ($("#" + AppConstants.elmIds.gameContainer).outerWidth(true) / 2) - ($("#TwoLetterWordsPanel").outerWidth(true) / 2);
        var top = $("#" + AppConstants.elmIds.gameContainer).position().top + ($("#" + AppConstants.elmIds.gameContainer).outerHeight(true) / 2) - ($("#TwoLetterWordsPanel").outerHeight(true) / 2);
        $("#TwoLetterWordsPanel").draggable({
            handle: ".header",
            containment: "#" + AppConstants.elmIds.gameContainer
        }).css({
            left: left + "px",
            top: top + "px"
        });
        $("#TwoLetterWordsPanel .header a").bind({
            mousedown: function () {
                TwoLetterWordsPanel.hide();
                return false;
            }
        });
    },
    hide: function () {
        $("#TwoLetterWordsPanel").fadeOut(function () {
            $(this).remove();
        });
    }
};
var ToolTip = {
    dom: null,
    addEvent: function (elm, displayTxt) {
        $(elm).data({
            toolTipDisplayText: displayTxt
        });
        $(elm).bind({
            mousemove: ToolTip.open,
            mouseout: ToolTip.close
        });
    },
    open: function (evt) {
        var left = evt.pageX;
        var top = evt.pageY + 25;
        if ($("#toolTip").html() == null) {
            var dom = BaseUI.create("div", {
                "id": "toolTip"
            });
            $(dom).css({
                left: left + "px",
                top: top + "px",
                "z-index": 3000
            }).html($(this).data("toolTipDisplayText"));
            $("#" + AppConstants.elmIds.gameContainer).append(dom);
        } else {
            $("#toolTip").css({
                left: left + "px",
                top: top + "px"
            });
        }
    },
    close: function () {
        $("#toolTip").remove();
    }
};
var StatModel = {
    data: {},
    setData: function (uid, val) {
        this.data[uid] = val;
    },
    hasData: function (uid) {
        return this.data.hasOwnProperty(uid);
    },
    getData: function (uid) {
        return this.data[uid];
    }
};
var StatPanel = {
    draw: function (data) {
        $("#userIndividualStat").remove();
        var dom = '<div id="userIndividualStat"><div class="header"><span>Stats for ' + data.name + '</span><a href="javascript:void(0)" class="close">X</a></div><div class="body">';
        dom += '<div class="blue"><div class="block">Games Played</div><div class="block"> : ' + data.finished + "</div></div>";
        dom += '<div class="white"><div class="block">Won</div><div class="block"> : ' + data.won + "</div></div>";
        dom += '<div class="blue"><div class="block">Lost</div><div class="block"> : ' + data.lost + "</div></div>";
        dom += '<div class="white"><div class="block">Drawn</div><div class="block"> : ' + data.drawn + "</div></div>";
        dom += '<div class="blue"><div class="block">Current Rating</div><div class="block"> : ' + data.currentrating + "</div></div>";
        dom += '<div class="white"><div class="block">Best Rating</div><div class="block"> : ' + data.bestrating + "</div></div>";
        dom += '</div><div class="footer"><a href="http://www.lexulous.com/email/stats?uid=' + data.uid + "&username=" + data.name + '" class="blueButton" target="_blank" onclick="StatPanel.hide();">More</a></div></div>';
        $("#" + AppConstants.elmIds.gameContainer).append(dom);
        $("#userIndividualStat").fadeIn();
        var left = $("#" + AppConstants.elmIds.gameContainer).position().left + ($("#" + AppConstants.elmIds.gameContainer).outerWidth(true) / 2) - ($("#userIndividualStat").outerWidth(true) / 2);
        var top = $("#" + AppConstants.elmIds.gameContainer).position().top + ($("#" + AppConstants.elmIds.gameContainer).outerHeight(true) / 2) - ($("#userIndividualStat").outerHeight(true) / 2);
        $("#userIndividualStat").draggable({
            handle: ".header",
            containment: "#" + AppConstants.elmIds.gameContainer
        }).css({
            left: left + "px",
            top: top + "px"
        });
        $("#userIndividualStat .header a").bind({
            mousedown: function () {
                StatPanel.hide();
                return false;
            }
        });
    },
    hide: function () {
        $("#userIndividualStat").fadeOut(function () {
            $(this).remove();
        });
    }
};
var Canvas = {
    draw: function () {
        $("#" + AppConstants.elmIds.gameContainer).bind({
            contextmenu: function () {
                return false;
            },
            mouseup: function (event) {
                if (ContextMenu.showing && event.which == 1) {
                    ContextMenu.hide();
                }
            }
        });
        $("#" + AppConstants.elmIds.headerPanel).hide();
        BodyPanel.create();
        PopUpBox.create();
        Autoloader.init();
        if (AppConstants.variables.firstTime && !Tutorial.firstTimeShown) {
            Tutorial.show();
        }
        $(window).bind({
            resize: function () {}
        });
        $(document).bind({
            lexGameboardMessageSuccess: function (evt, data) {
                EventCatcher.safeCall("EventCatcher.message.success", data);
            },
            lexGameboardMessageFailure: function (data) {
                EventCatcher.safeCall("EventCatcher.message.failure", data);
            },
            lexGameboardPassSuccess: function (data) {
                EventCatcher.safeCall("EventCatcher.pass.success", data);
            },
            lexGameboardPassFailure: function (data) {
                EventCatcher.safeCall("EventCatcher.pass.failure", data);
            },
            lexGameboardMoveSuccess: function (data) {
                EventCatcher.safeCall("EventCatcher.move.success", data);
            },
            lexGameboardMoveFailure: function (data) {
                EventCatcher.safeCall("EventCatcher.move.failure", data);
            },
            lexGameboardSwapSuccess: function (data) {
                EventCatcher.safeCall("EventCatcher.swap.success", data);
            },
            lexGameboardSwapFailure: function (data) {
                EventCatcher.safeCall("EventCatcher.swap.failure", data);
            },
            lexGameboardChallengeSuccess: function (data) {
                EventCatcher.safeCall("EventCatcher.challenge.success", data);
            },
            lexGameboardChallengeFailure: function (data) {
                EventCatcher.safeCall("EventCatcher.challenge.failure", data);
            },
            lexGameboardResignSuccess: function (data) {
                EventCatcher.safeCall("EventCatcher.resign.success", data);
            },
            lexGameboardResignFailure: function (data) {
                EventCatcher.safeCall("EventCatcher.resign.failure", data);
            },
            lexGameboardDeleteSuccess: function (data) {
                EventCatcher.safeCall("EventCatcher.delete.success", data);
            },
            lexGameboardDeleteFailure: function (data) {
                EventCatcher.safeCall("EventCatcher.delete.failure", data);
            },
            lexGameboardDicSuccess: function (data) {
                EventCatcher.safeCall("EventCatcher.dic.success", data);
            },
            lexGameboardDicFailure: function (data) {
                EventCatcher.safeCall("EventCatcher.dic.failure", data);
            },
            lexGameboardNextSuccess: function (data) {
                EventCatcher.safeCall("EventCatcher.next.success", data);
            },
            lexGameboardNextFailure: function (data) {
                EventCatcher.safeCall("EventCatcher.next.failure", data);
            }
        });
    },
    redraw: function () {
        HeaderPanel.destroy();
        BodyPanel.destroy();
        PopUpBox.destroy();
        this.draw();
    }
};
var Autoloader = {
    val: null,
    counter: 0,
    initonce: false,
    init: function () {
        if (AppConstants.variables.autoRefresh) {
            if (GameInfoModel.myTurn) {
                clearInterval(Autoloader.val);
                this.initonce = false;
                return;
            }
            if (this.initonce || GameInfoModel.myTurn) {
                return;
            }
            this.val = setInterval(function () {
                GameController.reload();
                Autoloader.counter++;
                if (Autoloader.counter >= 10) {
                    clearInterval(Autoloader.val);
                }
            }, 300000);
            this.initonce = true;
        }
    },
    stop: function () {
        if (AppConstants.variables.autoRefresh) {
            clearInterval(Autoloader.val);
            this.initonce = false;
        }
    }
};
var FeedBackPanel = {
    memData: [],
    add: function (txt) {
        this.memData.push(txt);
    },
    flush: function (txt) {
        this.memData = new Array();
    },
    show: function () {
        var dom = '<div>Please share your comments below:</div><textarea maxlength="500" class="feedbackTextArea"></textarea>';
        PopUpBox.open({
            title: "Feedback",
            body: dom,
            proceed: {
                text: "Send",
                execute: this.doAction,
                param: {
                    action: "SENDBUG"
                }
            },
            abort: {
                text: "Cancel"
            }
        });
    },
    doAction: function (obj) {
        switch (obj.action) {
        case "SENDBUG":
            var umsg = $("#feedbackTextArea").val() + "";
            var bmsg = FeedBackPanel.memData.join("\n<--->\n") + "";
            GameController.postRequest({
                action: GameController.postRequestType.contactMail,
                mail: {
                    userText: umsg,
                    bugText: bmsg
                }
            });
            break;
        }
    }
};
var EventCatcher = {
    safeCall: function (funcName, data) {
        if (typeof eval(funcName) == "function") {
            eval(funcName)(data);
        }
    },
    next: {
        success: function () {},
        failure: function () {}
    },
    dicCheck: {
        success: function () {},
        failure: function () {}
    },
    del: {
        success: function () {},
        failure: function () {}
    },
    resign: {
        success: function () {},
        failure: function () {}
    },
    challenge: {
        success: function () {},
        failure: function () {}
    },
    swap: {
        success: function () {},
        failure: function () {}
    },
    pass: {
        success: function () {},
        failure: function () {}
    },
    move: {
        success: function () {},
        failure: function () {}
    },
    message: {
        success: function (data) {},
        failure: function () {}
    }
};
var Tutorial = {
    firstTimeShown: false,
    showing: false,
    cIndex: 0,
    helpAction: [{
        "msg": '<span class="bold">These are your tiles.</span> Drag and drop them on to the board to make words!',
        "ct": "#elex_rackPanel"
    }, {
        "msg": '<span class="bold">Any one tile</span> of the first word, must cover the center star.',
        "ct": "#BoardCell_7_7"
    }, {
        "msg": '<span class="bold">Gives you 2x points</span> for any <span class="bold">tile</span> - e.g. get double points for "F" (5x2 = 10)',
        "ct": "#BoardCell_13_8"
    }, {
        "msg": '<span class="bold">Get 3x points for any letter you place on this</span> - e.g. "J" will be 8x3 = 24!',
        "ct": "#BoardCell_12_9"
    }, {
        "msg": '<span class="bold">Get 2x points for the entire word</span>, when any letter covers this.',
        "ct": "#BoardCell_13_12"
    }, {
        "msg": '<span class="bold">Get 3x points for the entire word</span>, use this wisely for amazing points!',
        "ct": "#BoardCell_14_14"
    }, {
        "msg": '<span class="bold">At any point during the game,</span> click to see some options / tiles remaining.',
        "ct": "#elex_optionMenu"
    }, {
        "msg": '<span class="bold">Can\'t think of a word?</span> Exchange some tiles or pass your turn.',
        "ct": "#elex_rightActionPanel"
    }, {
        "msg": '<span class="bold">That\'s it!</span> If your name is in red, then it means it\'s your turn. <span class="bold">Good luck!</span>',
        "ct": "#elex_playerList"
    }, {
        "msg": '<span class="bold">Played a word?</span> Click on "NEXT" to quickly play your turn in another game',
        "ct": "#elex_rightActionPanel"
    }],
    show: function (vin) {
        this.showing = true;
        if (vin == 9) {
            this.cIndex = 9;
        }
        var html = '<div id="pretutorial"></div><div class="tutorial" style="position:relative;z-index:10000;display:none;"><div class="tutorial_inner_wrapper"><div class="tutorial_container">';
        html += '<div class="upper_portion">' + this.helpAction[this.cIndex].msg + "</div>";
        html += '<div class="lower_portion">';
        if (this.cIndex > 0 && this.cIndex <= 8) {
            html += '<span class="mini_button grey_button_new_mini" onclick="Tutorial.back();">Back</span>';
        } else {
            if (this.cIndex == 0) {
                html += '<span class="mini_button grey_button_new_mini" style="visibility:hidden">Back</span>';
            }
        }
        if (this.cIndex == 9) {} else {
            html += '<span class="mini_text_holder"><span class="mini_green_text bold">' + (this.cIndex + 1) + "/9</span>&nbsp;";
            html += '<span class="skip" href="javascript:void(0);" onclick="Tutorial.skip();">[Skip]</span></span>';
        }
        html += '<span class="mini_button blue_button_new" onclick="Tutorial.next();">';
        if (this.cIndex == 8) {
            html += "Play</span>";
        } else {
            if (this.cIndex == 9) {
                html += "OK</span>";
            } else {
                html += "Next</span>";
            }
        }
        html += "</div></div></div>";
        if (this.cIndex == 6 || this.cIndex == 8) {
            html += '<div class="tutorial_bubble_arrow bubble_up">';
            html += '<div class="inner_bubble_up"></div>';
        } else {
            html += '<div class="tutorial_bubble_arrow bubble_down">';
            html += '<div class="inner_bubble_down"></div>';
        }
        html += "</div></div>";
        var position = $(Tutorial.helpAction[this.cIndex].ct).position();
        $("#" + AppConstants.elmIds.gameContainer).append(html);
        $("#pretutorial").css({
            "position": "relative",
            "left": 0,
            "top": 0,
            "z-index": "8000",
            "background-color": "#777777",
            width: $("#" + AppConstants.elmIds.gameContainer).outerWidth(true),
            height: $("#" + AppConstants.elmIds.gameContainer).outerHeight(true)
        }).fadeTo("fast", 0.8);
        if (this.cIndex > 0 && this.cIndex < 6) {
            var ss = $("#elex_boardPanelCont").position();
            position.left += ss.left;
            position.top += ss.top;
            var ww = parseInt($(Tutorial.helpAction[this.cIndex].ct).css("width").replace("px", ""));
            $(".tutorial").css({
                position: "absolute",
                left: position.left - ww + 3,
                top: position.top - 150
            }).fadeIn();
        } else {
            if (this.cIndex == 6 || this.cIndex == 8) {
                var de = parseInt($(Tutorial.helpAction[this.cIndex].ct).css("height").replace("px", ""));
                if (this.cIndex == 6) {
                    de += 12;
                } else {
                    de -= 16;
                }
                $(".tutorial").css({
                    position: "absolute",
                    left: position.left + 3,
                    top: position.top + de
                }).fadeIn();
            } else {
                if (this.cIndex == 0) {
                    $(".tutorial").css({
                        position: "absolute",
                        left: position.left + 3,
                        top: position.top - 109
                    }).fadeIn();
                } else {
                    $(".tutorial").css({
                        position: "absolute",
                        left: position.left + 3,
                        top: position.top - 150
                    }).fadeIn();
                }
            }
        }
    },
    next: function () {
        this.cIndex++;
        $(".tutorial").remove();
        if (this.cIndex <= 8) {
            this.show();
        } else {
            this.skip();
        }
    },
    back: function () {
        this.cIndex--;
        $(".tutorial").remove();
        if (this.cIndex >= 0) {
            this.show();
        } else {
            this.skip();
        }
    },
    skip: function () {
        $("#pretutorial").remove();
        $(".tutorial").remove();
        this.showing = false;
        this.firstTimeShown = true;
    }
};
var GameOverPopup = {
    open: function (gameOverList) {
        var popUp = '<div class="gameOverPopup" id="gameOverPopup">' + '<span class="clear" style="display:block;margin-bottom:12px;">' + '<h2 class="gameOver_popupHeading">Game Over</h2>' + '<a href="javascript:void(0);" title="close" class="closePopup" onclick="GameOverPopup.destroy();"></a>' + "</span>" + '<span style="font-size:14px;color:#333;"><span style="color:#0087f7;font-weight:bold;">You ' + gameOverList.txt + "</span> with a score of <b>" + gameOverList.myScore + " to " + gameOverList.oppScore + "!</b>" + " Would you like to start another game with " + gameOverList.oppName + "?</span>" + '<div class="clear" style="margin:12px 0 14px 0;padding-bottom:16px;border-bottom:1px solid #eaeaea;">' + '<a href="javascript:void(0);" class="grey_button flt_left" style="width:auto;padding:3px 6px;height:22px;line-height:22px;margin-right:8px;" onclick="GameOverPopup.destroy();">No</a>' + '<a href="javascript:void(0);" class="blue_button_new blue_button_new_big flt_left" style="color:#fff;font-weight:bold;padding:3px 6px;height:22px;line-height:22px;" onclick="UIEvent.board.playRematch();return false;">Rematch</a>' + "</div>" /*+ '<span class="clear" style="display:block;margin-bottom:12px;">' + '<h2 class="gameOver_popupHeading">Analyse</h2>' + '<span class="analyzeNew">New!</span>' + "</span>"*/;
        popUp = popUp + '<span style="font-size:14px;color:#333;">';
        if (gameOverList.psbMove == undefined) {} else {
            popUp = popUp + "Out of " + gameOverList.psbMove + " best possible moves, you played only " + gameOverList.psbMoveGiven + ".";
        }
        popUp = popUp + " See which words you missed to improve your game!</span>";
        popUp = popUp + '<div style="margin:21px 0 10px 0;"><a href="javascript:void(0);" onclick="GameOverPopup.analyze();" class="red_button red_button_new_big" style="color:#fff;font-weight:bold;padding:6px 15px 6px 14px;">Show Me</a></div>' + "</div>";
        $(popUp).appendTo("#" + AppConstants.elmIds.gameContainer);
        var left = $("#" + AppConstants.elmIds.gameContainer).position().left + ($("#" + AppConstants.elmIds.gameContainer).outerWidth(true) / 2) - ($("#gameOverPopup").outerWidth(true) / 2);
        var top = $("#" + AppConstants.elmIds.gameContainer).position().top + ($("#" + AppConstants.elmIds.gameContainer).outerHeight(true) / 2) - ($("#gameOverPopup").outerHeight(true) / 2) + 20;
        if (AppConstants.variables.hideAdvert == "y") {
            top = top + 98;
        }
        $("#gameOverPopup").css({
            "left": left + "px",
            "top": top + "px",
            "z-index": 9900
        });
    },
    analyze: function () {
        if (AppConstants.variables.analyzeUser) {
            GameOverPopup.destroy();
            CombinedPanel.analyze();
        } else {
            GameOverPopup.destroy();
            var event = jQuery.Event("ANALYZE_POPUP");
            $("body").trigger(event);
        }
    },
    destroy: function () {
        $("#gameOverPopup").remove();
    }
};
var AnalyzeExaminePopup = {
    showing: false,
    curPosition: null,
    analyzeData: null,
    analyzeDataCount: 0,
    open: function () {
        AppConstants.variables.analyzeGame = 1;
        this.curPosition = 0;
        this.showing = true;
        for (var yy = 0; yy < AppConstants.variables.boardColCount; yy++) {
            for (var xx = 0; xx < AppConstants.variables.boardRowCount; xx++) {
                var moveBoardData = BoardModel.getData(xx, yy);
                $("#" + BoardPanel.ids.boardCell + "_" + xx + "_" + yy + " div").hide();
            }
        }
        RackPanel.destroy();
        ActivityIndicator.show("Loading, ");
        rqStr = 'json={"fb_sig_user":"' + AppConstants.variables.gameAuthUser + '","gid":"' + AppConstants.variables.gameId + '","pid":"' + AppConstants.variables.gamePid + '"}';
        var send_url = AppConstants.variables.protocol + "aws.rjs.in/fblexulous/engine/game_analyse.php";
        $.ajax({
            url: send_url,
            data: rqStr,
            dataType: "json",
            success: function (result) {
                ActivityIndicator.hide();
                AnalyzeExaminePopup.anaMove(result);
            }
        });
    },
    hide: function () {
        this.showing = false;
        this.curPosition = MovesModel.lastMoveId();
        for (var yy = 0; yy < AppConstants.variables.boardColCount; yy++) {
            for (var xx = 0; xx < AppConstants.variables.boardRowCount; xx++) {
                $("#" + BoardPanel.ids.boardCell + "_" + xx + "_" + yy + " div").show();
            }
        }
    },
    anaMove: function (result) {
        this.analyzeData = result;
        var count = 0;
        var i;
        for (i in this.analyzeData) {
            if (this.analyzeData.hasOwnProperty(i)) {
                count++;
            }
        }
        this.analyzeDataCount = count;
        if (this.analyzeDataCount == 0) {
            var dom = "<div>Game #" + AppConstants.variables.gameId + " - a problem has occurred. Please contact support with this game number.</div>";
            PopUpBox.open({
                title: "Error",
                body: dom,
                proceed: {
                    feedback: 1
                }
            });
            return;
        }
        $("#prevAnaId").show();
        $("#nextAnaId").show();
        AnalyzeExaminePopup.doAction("NEXT");
    },
    wordHide: function (wordpos) {
        for (var yy = 0; yy < AppConstants.variables.boardColCount; yy++) {
            for (var xx = 0; xx < AppConstants.variables.boardRowCount; xx++) {
                var moveBoardData = BoardModel.getData(xx, yy);
                if (moveBoardData.moveId == this.curPosition) {
                    $("#" + BoardPanel.ids.boardCell + "_" + xx + "_" + yy + " div").hide();
                }
            }
        }
        word = wordpos.split(",");
        for (var i = 2; i < word.length; i = i + 3) {
            var score = TileModel.getData(word[i]);
            if (word[i].charCodeAt(0) >= 97 && word[i].charCodeAt(0) <= 122) {
                $("#" + BoardPanel.ids.boardCell + "_" + word[i - 2] + "_" + word[i - 1]).html('<div class="tileLastPlayed" style="z-index: 200; left: 0px; top: 0px;"><div class="tilePlayedKey" style="display: block;color: rgb(254, 34, 50);">' + word[i].toUpperCase() + "</div></div>");
            } else {
                $("#" + BoardPanel.ids.boardCell + "_" + word[i - 2] + "_" + word[i - 1]).html('<div class="tileLastPlayed" style="z-index: 200; left: 0px; top: 0px;"><div class="tilePlayedKey" style="display: block;color:rgb(243, 242, 242);">' + word[i] + '<span class="tileValue">' + score + "</span></div></div>");
                if (score == 12) {
                    $("#" + BoardPanel.ids.boardCell + "_" + word[i - 2] + "_" + word[i - 1]).html('<div class="tileLastPlayed" style="z-index: 200; left: 0px; top: 0px;"><div class="tilePlayedKey" style="display: block;color:rgb(243, 242, 242);">' + word[i] + '<span class="tileValue" style="font-size:8px;">' + score + "</span></div></div>");
                }
            }
        }
    },
    wordShow: function (wordpos) {
        word = wordpos.split(",");
        for (var i = 2; i < word.length; i = i + 3) {
            var lt = BoardModel.getData(word[i - 2], word[i - 1]);
            if (lt.chr != "") {
                var score = TileModel.getData(lt.chr);
                if (word[i].charCodeAt(0) >= 97 && word[i].charCodeAt(0) <= 122) {
                    $("#" + BoardPanel.ids.boardCell + "_" + word[i - 2] + "_" + word[i - 1]).html('<div class="tileLastPlayed" style="z-index: 200; left: 0px; top: 0px;"><div class="tilePlayedKey" style="display: block;color: rgb(254, 34, 50);">' + lt.chr.toUpperCase() + "</div></div>");
                } else {
                    $("#" + BoardPanel.ids.boardCell + "_" + word[i - 2] + "_" + word[i - 1]).html('<div class="tileLastPlayed" style="z-index: 200; left: 0px; top: 0px;"><div class="tilePlayedKey" style="display: block;color:rgb(243, 242, 242);">' + lt.chr + '<span class="tileValue">' + score + "</span></div></div>");
                    if (score == 12) {
                        $("#" + BoardPanel.ids.boardCell + "_" + word[i - 2] + "_" + word[i - 1]).html('<div class="tileLastPlayed" style="z-index: 200; left: 0px; top: 0px;"><div class="tilePlayedKey" style="display: block;color:rgb(243, 242, 242);">' + lt.chr + '<span class="tileValue" style="font-size:8px;">' + score + "</span></div></div>");
                    }
                }
            } else {
                $("#" + BoardPanel.ids.boardCell + "_" + word[i - 2] + "_" + word[i - 1]).html("");
            }
            $("#" + BoardPanel.ids.boardCell + "_" + word[i - 2] + "_" + word[i - 1] + " div").hide();
        }
        for (var yy = 0; yy < AppConstants.variables.boardColCount; yy++) {
            for (var xx = 0; xx < AppConstants.variables.boardRowCount; xx++) {
                var moveBoardData = BoardModel.getData(xx, yy);
                if (moveBoardData.moveId == this.curPosition) {
                    $("#" + BoardPanel.ids.boardCell + "_" + xx + "_" + yy + " div").show();
                }
            }
        }
    },
    doAction: function (action) {
        var msg = "";
        switch (action) {
        case "FIRST":
            this.curPosition = 1;
            break;
        case "LAST":
            this.curPosition = MovesModel.lastMoveId();
            break;
        case "PREVIOUS":
            this.curPosition--;
            if (this.curPosition < 1) {
                this.curPosition = 1;
                msg = "no more moves";
            }
            break;
        case "NEXT":
            this.curPosition++;
            if (this.curPosition > MovesModel.lastMoveId()) {
                this.curPosition = MovesModel.lastMoveId();
                msg = "this was the last move";
            }
            break;
        }
        var anaTxt = "Move " + this.curPosition + " of " + this.analyzeDataCount;
        $("#prevAnaTxt").html(anaTxt);
        var moveData = MovesModel.getData((this.curPosition == MovesModel.lastMoveId()) ? this.curPosition - 1 : this.curPosition);
        msg += "&nbsp;";
        for (var yy = 0; yy < AppConstants.variables.boardColCount; yy++) {
            for (var xx = 0; xx < AppConstants.variables.boardRowCount; xx++) {
                var moveBoardData = BoardModel.getData(xx, yy);
                var score = TileModel.getData(moveBoardData.chr);
                var color = AppConstants.styleClasses.tilePlayed;
                if (moveBoardData.moveId == this.curPosition) {
                    color = AppConstants.styleClasses.tileLastPlayed;
                }
                if (moveBoardData.moveId == this.curPosition) {
                    if (moveBoardData.chr.charCodeAt(0) >= 97 && moveBoardData.chr.charCodeAt(0) <= 122) {
                        $("#" + BoardPanel.ids.boardCell + "_" + xx + "_" + yy).html('<div class="tileLastPlayed" style="z-index: 200; left: 0px; top: 0px;"><div class="tilePlayedKey" style="display: block;color: rgb(254, 34, 50);">' + moveBoardData.chr.toUpperCase() + "</div></div>");
                    } else {
                        if (score == 12) {
                            $("#" + BoardPanel.ids.boardCell + "_" + xx + "_" + yy).html('<div class="tileLastPlayed" style="z-index: 200; left: 0px; top: 0px;"><div class="tilePlayedKey" style="display: block;color:rgb(243, 242, 242);">' + moveBoardData.chr + '<span class="tileValue" style="font-size:8px;">' + score + "</span></div></div>");
                        } else {
                            $("#" + BoardPanel.ids.boardCell + "_" + xx + "_" + yy).html('<div class="tileLastPlayed" style="z-index: 200; left: 0px; top: 0px;"><div class="tilePlayedKey" style="display: block;color:rgb(243, 242, 242);">' + moveBoardData.chr + '<span class="tileValue">' + score + "</span></div></div>");
                        }
                    }
                }
                if (moveBoardData.moveId == this.curPosition - 1 && moveBoardData.moveId != 0) {
                    if (moveBoardData.chr.charCodeAt(0) >= 97 && moveBoardData.chr.charCodeAt(0) <= 122) {
                        $("#" + BoardPanel.ids.boardCell + "_" + xx + "_" + yy).html('<div class="tilePlayed" style="z-index: 200; left: 0px; top: 0px;"><div class="tilePlayedKey" style="display: block;color: rgb(254, 34, 50);">' + moveBoardData.chr.toUpperCase() + "</div></div>");
                    } else {
                        $("#" + BoardPanel.ids.boardCell + "_" + xx + "_" + yy).html('<div class="tilePlayed" style="z-index: 200; left: 0px; top: 0px;"><div class="tilePlayedKey" style="display: block;">' + moveBoardData.chr + '<span class="tileValue">' + score + "</span></div></div>");
                        if (score == 12) {
                            $("#" + BoardPanel.ids.boardCell + "_" + xx + "_" + yy).html('<div class="tilePlayed" style="z-index: 200; left: 0px; top: 0px;"><div class="tilePlayedKey" style="display: block;">' + moveBoardData.chr + '<span class="tileValue" style="font-size:8px;">' + score + "</span></div></div>");
                        }
                    }
                }
                if (moveBoardData.moveId <= this.curPosition) {
                    $("#" + BoardPanel.ids.boardCell + "_" + xx + "_" + yy + " div").show();
                } else {
                    $("#" + BoardPanel.ids.boardCell + "_" + xx + "_" + yy + " div").hide();
                }
            }
        }
        var moveData = this.analyzeData[this.curPosition].moveset;
        var allword = "";
        for (var key in moveData) {
            var mv = moveData[key];
            var score = mv.score;
            var wordpos = mv.set;
            var cnt = wordpos.length;
            var fstl = wordpos[0];
            var fstlt = fstl.split(",");
            var lstl = wordpos[cnt - 1];
            var lstlt = lstl.split(",");
            var word = "";
            if (cnt == 1) {
                word = fstlt[2];
                var lstWord = word;
                var flag = 0;
                var leftS = BoardModel.getData(parseInt(fstlt[0]) - 1, fstlt[1]);
                if (leftS != null && (leftS.moveId < this.curPosition) && leftS.chr != "") {
                    for (var r = parseInt(fstlt[0] - 1); r >= 0; r--) {
                        var front = BoardModel.getData(r, fstlt[1]);
                        if (front != null && (front.moveId < this.curPosition)) {
                            if (front.chr != "") {
                                lstWord = front.chr + lstWord;
                            } else {
                                break;
                            }
                        }
                    }
                }
                if (lstWord != word) {
                    flag = 1;
                }
                var rightS = BoardModel.getData(parseInt(fstlt[0]) + 1, fstlt[1]);
                if (rightS != null && (rightS.moveId < this.curPosition) && rightS.chr != "" && flag == 0) {
                    for (var r = parseInt(fstlt[0]) + 1; r < 15; r++) {
                        var front = BoardModel.getData(r, fstlt[1]);
                        if (front != null && (front.moveId < this.curPosition)) {
                            if (front.chr != "") {
                                lstWord = lstWord + front.chr;
                            } else {
                                break;
                            }
                        }
                    }
                }
                if (lstWord != word) {
                    flag = 1;
                }
                var leftC = BoardModel.getData(fstlt[0], parseInt(fstlt[1]) - 1);
                if (leftC != null && (leftC.moveId < this.curPosition) && leftC.chr != "" && flag == 0) {
                    for (var r = parseInt(fstlt[1]) - 1; r >= 0; r--) {
                        var front = BoardModel.getData(fstlt[0], r);
                        if (front != null && (front.moveId < this.curPosition)) {
                            if (front.chr != "") {
                                lstWord = front.chr + lstWord;
                            } else {
                                break;
                            }
                        }
                    }
                }
                if (lstWord != word) {
                    flag = 1;
                }
                var rightC = BoardModel.getData(fstlt[0], parseInt(fstlt[1]) + 1);
                if (rightC != null && (rightC.moveId < this.curPosition) && rightC.chr != "" && flag == 0) {
                    for (var r = parseInt(fstlt[1]) + 1; r < 15; r++) {
                        var front = BoardModel.getData(fstlt[0], r);
                        if (front != null && (front.moveId < this.curPosition)) {
                            if (front.chr != "") {
                                lstWord = lstWord + front.chr;
                            } else {
                                break;
                            }
                        }
                    }
                }
                word = lstWord;
            } else {
                if (parseInt(fstlt[0]) == parseInt(lstlt[0])) {
                    var j = cnt - 1;
                    for (var i = parseInt(lstlt[1]); i <= parseInt(fstlt[1]); i++) {
                        var letters = wordpos[j];
                        var lt = letters.split(",");
                        if (lt[1] == i) {
                            j = j - 1;
                            word = word + lt[2];
                        } else {
                            lt[2] = BoardModel.getData(fstlt[0], i);
                            word = word + lt[2].chr;
                        }
                    }
                    for (var r = parseInt(lstlt[1]) - 1; r >= 0; r--) {
                        var front = BoardModel.getData(parseInt(fstlt[0]), r);
                        if (front != null && (front.moveId < this.curPosition)) {
                            if (front.chr == "") {
                                break;
                            } else {
                                word = front.chr + word;
                            }
                        }
                    }
                    var t = parseInt(fstlt[1]) + 1;
                    for (var r = parseInt(fstlt[1]) + 1; r < 15; r++) {
                        var back = BoardModel.getData(parseInt(fstlt[0]), r);
                        if (back != null && (back.moveId < this.curPosition)) {
                            if (back.chr == "") {
                                break;
                            } else {
                                if (t == r) {
                                    word = word + back.chr;
                                } else {
                                    break;
                                }
                            }
                            t = t + 1;
                        }
                    }
                } else {
                    if (parseInt(fstlt[1]) == parseInt(lstlt[1])) {
                        var j = cnt - 1;
                        for (var i = parseInt(lstlt[0]); i <= parseInt(fstlt[0]); i++) {
                            var letters = wordpos[j];
                            var lt = letters.split(",");
                            if (lt[0] == i) {
                                j--;
                                word = word + lt[2];
                            } else {
                                lt[2] = BoardModel.getData(i, fstlt[1]);
                                word = word + lt[2].chr;
                            }
                        }
                        for (var r = parseInt(lstlt[0]) - 1; r >= 0; r--) {
                            var front = BoardModel.getData(r, parseInt(fstlt[1]));
                            if (front != null && (front.moveId < this.curPosition)) {
                                if (front.chr == "") {
                                    break;
                                } else {
                                    word = front.chr + word;
                                }
                            }
                        }
                        var t = parseInt(fstlt[0]) + 1;
                        for (var r = parseInt(fstlt[0]) + 1; r < 15; r++) {
                            var back = BoardModel.getData(r, parseInt(fstlt[1]));
                            if (back != null && (back.moveId < this.curPosition)) {
                                if (back.chr == "") {
                                    break;
                                } else {
                                    if (t == r) {
                                        word = word + back.chr;
                                    } else {
                                        break;
                                    }
                                }
                                t = t + 1;
                            }
                        }
                    }
                }
            }
            word = '<a href="http://www.oneworddaily.com/?action=search&search=' + word + '" onmouseover="AnalyzeExaminePopup.wordHide(\'' + wordpos + "');\" onmouseout=\"AnalyzeExaminePopup.wordShow('" + wordpos + '\');" target="_blank" style="color: #ff6b08;font-weight: bold;line-height: 20px;text-decoration: none;">' + word + " (" + mv.score + ")" + "</a>";
            allword = allword + word + "<br />";
        }
        var p1Name = $("#elex_playerList div:nth-child(2) a:first-child").html();
        var p2name = $("#elex_playerList div:nth-child(1) a:first-child").html();
        var turnId = this.analyzeData[this.curPosition].played;
        var word = this.analyzeData[this.curPosition].word + ' <span style="color:#565656;">(' + this.analyzeData[this.curPosition].score + ")</span>";
        var moveType = MovesModel.getData(this.curPosition - 1);
        if (moveType.moveType == "SWAP") {
            word = "SWAPPED " + this.analyzeData[this.curPosition].word + " tiles";
        }
        if (moveType.moveType == "PASS") {
            word = "PASSED TURN";
        }
        var pDt = PlayersModel.getInfoByPid(turnId);
        if (AppConstants.variables.gamePid == 2) {
            if (turnId == 1) {
                $(".turnArrow").remove();
                $("#elex_playerList div:nth-child(2)").append('<div class="turnArrow" style="opacity: 1;"></div>');
                var playedBy = pDt.name;
            } else {
                $(".turnArrow").remove();
                $("#elex_playerList div:nth-child(1)").append('<div class="turnArrow" style="opacity: 1;"></div>');
                var playedBy = "You";
            }
        } else {
            if (AppConstants.variables.gamePid == 1) {
                if (turnId == 1) {
                    $(".turnArrow").remove();
                    $("#elex_playerList div:nth-child(1)").append('<div class="turnArrow" style="opacity: 1;"></div>');
                    var playedBy = "You";
                } else {
                    $(".turnArrow").remove();
                    $("#elex_playerList div:nth-child(2)").append('<div class="turnArrow" style="opacity: 1;"></div>');
                    var playedBy = pDt.name;
                }
            }
        }
        allword = '<div style="border-bottom:1px solid #ccc;padding:10px 16px;">' + playedBy + ' played <br/><span style="color:#44bb85;font-size:18px;font-weight: bold;line-height:24px;">' + word + "</span></div>" + '<div style="padding:10px 10px 10px 16px;">Other possible words<div class="chatScroll" style="margin-bottom:7px;">' + allword + "</div></div>";
        var moveRack = this.analyzeData[this.curPosition].rack;
        RackPanel.destroy();
        RackPanel.create();
        for (var k = 0; k < moveRack.length; k++) {
            RackPanel.addToRack(moveRack[k]);
        }
        $("#anaBodyDiv").html(allword);
    }
};