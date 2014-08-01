routes.routes1.type="regex"
routes.routes1.match="#^/routes/(\d+)#"
routes.routes1.route.module=index
routes.routes1.route.controller=routes1
routes.routes1.route.action=index
routes.routes1.map.1=id1


routes.routes2.type="regex"
routes.routes2.match="#^/routes-1/(\d+)#"
routes.routes2.route.module=index
routes.routes2.route.controller=routes1
routes.routes2.route.action=index1
routes.routes2.map.1=id2


;simple
routes.simple.type="simple"
routes.simple.controller=c
routes.simple.module=m
routes.simple.action=a
;supervar
routes.supervar.type="supervar"
routes.supervar.varname=r

