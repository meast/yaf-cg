[common]
application.directory = PATH_APP "/app"
application.library = PATH_APP "/app/library"
application.bootstrap = PATH_APP "/app/bootstrap.php"
application.dispatcher.decaultModule = "index"
application.dispatcher.defaultController = "index"
application.dispatcher.defaultAction = "index"
application.dispatcher.charset = "utf-8"
application.modules = "index,admin,test,wx"
application.system.lowcase_path = true
application.common.varpage = "p"
application.view.ext="phtml"
layout.dir=PATH_APP "/app/layouts/"
layout.file=default.phtml

db.sample.dsn = "sqlite:"PATH_APP"/db/sample.db"
db.sample.username = ""
db.sample.password = ""
db.sample.cachedir = "sample"


[development : common]
application.dispatcher.throwException = true
application.dispatcher.catchException = true
application.dispatcher.errorview = "error/error.phtml"

[product : common]
application.dispatcher.throwException = true
application.dispatcher.catchException = true
application.dispatcher.errorview = "error/error-product.phtml"
