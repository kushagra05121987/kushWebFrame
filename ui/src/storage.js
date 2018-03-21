window.onload = function () {
    // All the Storage keys/values will be converted to string first and then assigned
    var storageItem1 = { "name": "kushagra" };
    var storageItem2 = [12, 34, 56];
    var storageItem3 = 34;
    var storageItem4 = "game";
    // var storageItem5 = Symbol("Session Storage"); // hence syambil cannot be converted to string

    // Session storage
    sessionStorage.setItem(storageItem1, "one");
    sessionStorage.setItem(storageItem2, 2);
    sessionStorage.setItem(storageItem3, { "age": 30 }); // needs to be converted to string while storing  so that when retieving we don't get [Object object] format
    sessionStorage.setItem(storageItem4, [23, 22, 444]);
    sessionStorage.setItem(storageItem3, JSON.stringify({ "age": 30 }));

    // console.log("%c Session Storage ", "background: red; color: white");
    // console.log(sessionStorage.getItem(storageItem1));
    // console.log(sessionStorage.getItem(storageItem2));
    // console.log(sessionStorage.getItem(storageItem3));
    // console.log(sessionStorage.getItem(storageItem4));
    // console.log(sessionStorage.getItem(storageItem5));

    sessionStorage.removeItem(storageItem1);

    // console.log(sessionStorage);

    sessionStorage.clear();

    // console.log(sessionStorage);

    // console.log("%c Local Storage ", "background: red; color: white");    
    // Local storage
    localStorage.setItem(storageItem1, "one");
    localStorage.setItem(storageItem2, 2);
    localStorage.setItem(storageItem3, { "age": 30 });
    localStorage.setItem(storageItem4, [23, 22, 444]);
    // localStorage.setItem(storageItem5, 34.44);

    // console.log(localStorage.getItem(storageItem1));
    // console.log(localStorage.getItem(storageItem2));
    // console.log(localStorage.getItem(storageItem3));
    // console.log(localStorage.getItem(storageItem4));
    // console.log(localStorage.getItem(storageItem5));

    localStorage.removeItem(storageItem1);

    // console.log(localStorage);

    localStorage.clear();

    // console.log(localStorage);

    // Web Sql
    // WONT WORK IN FIREFOX
    // This is based on SQLite
    // Asynchronous behaviour. Donot return result as a return value but use a callback to pass the transaction and resulset into it.
    // Will persist untill deleted by user or user settings.
    // everything goes inside transaction only and nothing works out side transaction.
    // The version number is a required argument to openDatabase, so you must know the version number before you try to open it. Otherwise, an exception is thrown.
    var dbSize = 1024 * 1024 * 5; // 5MB
    var websqlDB = openDatabase("TestDB", "1", "Test DB", dbSize); // name, version, description, size
    var onError = function (tx, err) {
        // console.log("An error occured", err.message);
    }
    var onSuccess = function (tx, response) {
        // console.log("Success");
        // console.log(tx);
        // console.log(response);        
    }

    websqlDB.transaction(function (tx) {
        console.log("inside", tx);
        window.tran = tx;
        // This will persist and everytime the page is reloaded it will add a new value but only if primary key is autoincrementing. Otherwise it will check if the primary key is already present then it will not insert that same key again and again.
        tx.executeSql("CREATE TABLE IF NOT EXISTS testTable (id INTEGER(10) PRIMARY KEY AUTO_INCREMENT, name VARCHAR(20), age INTEGER(4))");
    });

    // execute multiple things inside transaction callback so that if somthing goes wrong the whole transaction can be rolled back.
    websqlDB.transaction(function (tx) {
        tx.executeSql("insert into testTable values(null, 'Kushagra Mishra', 30)");
        tx.executeSql("SELECT COUNT(*) as rowCount FROM testTable", [], onSuccess, onError);
    });

    // readTransactionn is read only transaction
    websqlDB.readTransaction(function (tx) {
        tx.executeSql("select * from testTable", [], onSuccess, onError);
        tx.executeSql("insert into testTable values(null, 'Ekta Mishra', 30)", [], onSuccess, onError); // results in error saying: An error occured could not prepare statement (23 not authorized)
    });

    // transaction only is read/write transation
    websqlDB.transaction(function (tx) {
        tx.executeSql("select * from testTable", [], onSuccess, onError);
    });

    // this will not work outside the transaction or readTransaction not because its not allowed but there won't be any transaction variable available outside the transaction callback because all the transaction are asynchronous and the following code gets executed before transaction variable is created.
    // window.tran.executeSql("select * from testTable", [], onSuccess, onError); // window.tran not defined
    // setTimeout(function() {
    //     window.tran.executeSql("select * from testTable", [], onSuccess, onError); // SQL execution is disallowed.
    // }, 500);
    // Web Sql is deprecated in most of the browsers and now IndexedDB is taking its place.

    // IndexedDB is nosql
    window.indexedDB = window.indexedDB || window.mozIndexedDB || window.webkitIndexedDB || window.msIndexedDB;
    if (!window.indexedDB) {
        console.log("Your Browser does not support IndexedDB");
    }
    console.log("indexedDB", window.indexedDB);

    var createReq = window.indexedDB.open("testDB", 2); // db name and version // Once version is created we cannot go back and open the lower version otherwise we will get error.s

    console.log("Create Request", createReq);
    var db;
    // now createReq can use four event callbacks success, error, upgradeneeded, blocked
    // every event has its request as a part.
    createReq.onsuccess = function (e) {
        db = e.target.result;
        console.log("DB: ", db);
        console.log("Indexed DB success Creation", e);

        // open a transaction
        var transaction = db.transaction(["students"], "readwrite");
        transaction.oncomplete = function (event) {
            console.log("Successful transaction");
        };

        transaction.onerror = function (event) {
            console.log("Error transaction.");
        };

        var objectStore = transaction.objectStore("students");
        console.log("Object Store: ", objectStore);
        // Whatever type of request is there add, get, update or delete we always have .results property inside it which will have the results from the current operation. For add its undefined, for get its the actual data. This result can be also found inside target.result property of the event. 
        objectStore.autoIncrement = true
        console.log("All values: ", objectStore.getAll());
        var time = new Date();
        var addReq = objectStore.add({ name: "Kushagra", "added_on": time }); // Key Already exists otherwise use autoincrement and leave key empty
        var putReq = objectStore.put({ name: "Ekta",details: {first: "John", last: "Doe"}, "added_on": time,  }); // add also adds and put also adds but put can also update. Add always adds new entry but put updates the entry if it exists otherwise creates new.
        console.log("Add Requet: ", addReq);
        addReq.onsuccess = function (e) {
            console.log("Add Rollno: ", e);
        }
        addReq.onerror = function (e) {
            console.log("Error Adding Roll number", e);
        }

        var obStore = transaction.objectStore("students");
        var getReq = obStore.get(20); 
        console.log("Get Request: ",getReq);
        getReq.onsuccess = function (e) {
            console.log("Get Rollno: ", e);
        }
        getReq.onerror = function (e) {
            console.log("Error Getting Roll number", e);
        }

        // get By index
        var index = obStore.index("added_on");
        var reqIndex = index.get(time);
        console.log("Index Request: ", reqIndex);
        reqIndex.onsuccess = function(e) {
            reqIndex.result.name = "daniala"
            obStore.put(reqIndex.result);
            console.log("Index Request Success: ", e);
        }
        reqIndex.onerror = function (e) {
            console.log("Error Getting Index Request:", e);
        }

        // update the data
    }
    createReq.onerror = function (e) {
        console.log("Indexed DB Error Creation", e);
    }``
    // onupgradeneeded event will be called whenever the webpage is hit for the first time on user’s web browser and if there is an upgrade in version of database. So if Storage doesnot exists then also it will go to onupgradeneeded. oldVersion: 0, newVersion: 1
    createReq.onupgradeneeded = function (e) {
        console.log("Indexed DB Upgrade Needed", e);
        // because this will be executed only once when a version is created we can use this place to create datastore so that we don't have to keep checking if datastore doesnot exist then only create it.
        // e.target has the value of the actual IDBRequestObject which is createReq and this request's result has IDBDatabase object.
        db = e.target.result;
        var os = db.createObjectStore("students", { keyPath: "rollNo", autoIncrement: true });
        // In above code snippet, we are creating a Object Store named “students” with index key “roll no”.
        // following needs to be run only inside this callback
        os.createIndex("added_on", "added_on", {unique: false});
        console.log("Object Strore after new index: ", os);
    }
    //onblocked event occurs if previous connection was never closed.
    createReq.onblocked = function (e) {
        console.log("Indexed DB Blocked", e);
    }

}