var Comanda = Class.create();

	
		
/**
 *  En esta clase que arma la comanda con cada producto sque se le va haciendo click
 */
Comanda.prototype = {
	
	  initialize: function(varMozo, varMesa) {
	    this.productos  = new Array(); 
	    this.mesa = varMesa;
	    this.mozo = varMozo;	    
	    /**
	     * este atributo sirve para identificar si la comanda va con prioridad o no
	     * @var prioridad
	     */
	    this.prioridad = false;
	    
	    this.h1 = new Element('H1').update("Comanda");    
	    this.h1.observe('click',this.tooglePrioridad.bind(this));
	    
	    $('contenedor-comandas').appendChild(new Element('div',{'id': 'comanda'})).appendChild(this.h1);
	    $('comanda').appendChild(new Element('p',{'id':'comanda-enviar', 'class': 'menu-horizontal'}));
	    
	    div1 = new Element('div',{'class': 'menu-horizontal menu-margen'});
	    div1.appendChild(new Element('ul',{'id':'comanda-ul'}));
	    $('comanda').appendChild(div1);
	    //$('comanda').appendChild(new Element('ul',{'id':'comanda-ul', 'class': 'menu-vertical'}));
	    
	    
		$('comanda-enviar').appendChild(new Element('a', {
				'class':'boton letra-chica',
				'href': '#EnviarComanda',
				'onClick': 'adicion.comanda.imprimirComanda(); return false;'})).update("Mandar Comanda");
		
		$('comanda-enviar').appendChild(new Element('a', {
				'class':'boton letra-chica',
				'href': '#EnviarComandaNoImprimir',
				'onClick': 'adicion.comanda.guardarComanda(); return false;'})).update("Sin imprimir");
	  },
	  
	  
	  /**
	   * Cambia la prioridad de la comanda
	   */
	  tooglePrioridad: function(){
		  if(this.prioridad == false){
			  this.prioridad = true;
			  this.h1.update('Comanda Prioridad');
		  }
		  else{
			  this.prioridad = false;
			  this.h1.update('Comanda');
		  }
	  },
	  
	  resetearComanda: function(varMozo, varMesa){
		  this.productos = new Array();
		  this.mesa = varMesa;
		  this.mozo = varMozo;
		  $('comanda-ul').update(""); // le vacio el contenido          
	  },
	  
	  
	  /**
	   * currentMesa
	   * Este inserta los productos en la comanda y los muestra por pantalla
	   * 
	   */
	  actualizarComanda: function(){
		  $('comanda-ul').update('');
		 
		  this.productos.each(function(p){
			  if(p.cantidad > 0){
				  var li = new Element('li');
				  
				  var a = new Element('a',{
					  			'id':'comanda-producto-'+p.getId(),
					  			'onClick': "adicion.comanda.restar('"+Object.toJSON(p)+"')"
					  			}
				  ).update(p.getCantidad()+" --| "+p.getName());
				  
				  li.appendChild(a);
				  $('comanda-ul').appendChild(li);
			  }
		  });
		 
	  },

	  
	 
	  imprimirComanda: function(){
		  var imprimir = true;
		  this.enviarComanda(imprimir);
	  },
	  
	  
	  /**
	   * envia la comanda usando ajax para que PHp la procese, guarde todo en BD y mande a imprimir la comanda
	   * 
	   * devuelve true o false si el usuario hizo OK al confirm dialog
	   */
	  guardarComanda: function(){
		  if(window.confirm("¿realmente desea guardar la comanda SIN enviar a imprimir?")){
			var imprimir = false;
		  	this.enviarComanda(imprimir);
		  	return true;
		  }
		  return false;
	  },
	  
	  /**
	   * envia la comanda usando ajax para que PHp la procese, guarde todo en BD y mande a imprimir la comanda
	   */
	  enviarComanda: function(imprimir){
		  console.info("Se envió una comanda para imprimir, la del mozo "+this.mozo.id+" mesa "+this.mesa.id);
		  //armo el formulario que voy  a enviar
		  var formulario = new Element('form', {'name':'Comanda', 'action':'http://localhost/ristorantino/DetalleComandas/add/mesa_id:'+this.mesa.id+'/mozo_id:'+this.mozo.id});
		 	
		  //voy armando el formulario y generando el $this->data[]
		  formulario.appendChild(new Element('input', {'name': 'data[imprimir]'}).setValue(imprimir)); //dice si hay que mandar a imprimr o solo guardar los datos
		  formulario.appendChild(new Element('input', {'name': 'data[Comanda][prioridad]'}).setValue(this.prioridad)); //avisa si la comanda va con prioridad o no
		  
		  // le agrego los productos con su rspectiva catidad
		  var count = 0; 
		  this.productos.each(function(p){
			  formulario.appendChild(new Element('input', {'name': 'data[DetalleComanda]['+count+'][producto_id]'}).setValue(p.getId()));
			  formulario.appendChild(new Element('input', {'name': 'data[DetalleComanda]['+count+'][cant]'}).setValue(p.getCantidad()));
			  formulario.appendChild(new Element('input', {'name': 'data[DetalleComanda]['+count+'][mesa_id]'}).setValue(this.mesa.id));
			  count++;
		  }.bind(this));
		  
		  
		  console.info("form serializado:::"+formulario.serialize());
		  
		  formulario.request({
			  	parameters: formulario.serialize(),
		        onFailure: function() {
			  		alert("Fallò, no se ha impreso la comanda. Por favor ingrese los datos nuevamente") ;
			  		console.info("Fallo el ajax para enviar la comanda");			  	
		  		},
		        onSuccess: function(t) {
		            this.resetearComanda(this.mozo, this.mesa); //esto ademas de resetar los datos de la comanda, oculta el DIV "comanda"
		            $('contenedor-comandas').hide();
		            console.info("se mandò a imprimir y se resetearon los datos de la comanda");	
		            if(imprimir){
		            	alert('Se mandó a imprimir la comanda');
		            }
		        }.bind(this)
		    });
	  },
	  	  
	  /**
	   * Agrega un producto a la comanda
	   * @param producto_agregar es el JSON del producto
	   * @return
	   */
	  	add: function(producto_agregar) {
		  var producto = new ProductoComanda();
		  //covierto el JSON en productoComanda
		  producto.copiar(producto_agregar);
				  
		  var prod_busq = new ProductoComanda();
	  
		  prod_busq = this.buscar(producto);
		  
		  console.info("esto es lo que encontró");
		  console.debug(prod_busq);
		  if (prod_busq == null){ // si no estaba en la coleccion lo meto	
			  this.__agregarProducto(producto);
			  console.info("se agregò un producto a la comanda. El producto:"+producto.getName()+"..... y actualmente hay "+this.productos.length+" productos en la coleccion");
		  }
		  else{ // ya estaba en la coleccion , asqiue solo le incremento el valor cantidad
			  prod_busq.sumar();
			  console.info("ya estaba, solo le incremente el valor");
		  }

		  this.actualizarComanda();
		  return this.productos.length;
	  },
	  
	  /**
	   * agrega un producto en la cola deproductos y le incrementa en 1 la cantidad
	   * @param producto
	   * @return
	   */
	  __agregarProducto: function(producto)
	  {		  
		  this.productos.push(producto);
		  producto.sumar();
	  },
	  
	  
	  __restarProducto: function(producto){
		  producto.restar();
	  },
	  
	  restar: function(prod) {
		  var producto = new ProductoComanda();
		  //covierto el JSON en productoComanda
		  producto.copiar(prod);
				  
		  var prod_busq = new ProductoComanda();
	  
		  prod_busq = this.buscar(producto);
		  
		  if (prod_busq != null){ // si estaba lo resto
			  this.__restarProducto(prod_busq);
		  }

		  this.actualizarComanda();
		  return this.productos.length;
	  },

	  	/**
	  	 * 
	  	 *  busca el producto por su id, si lo encuenta devuelve el producto
	  	 *  si no encuentra nada devuelve null
	  	 *  @params producto es el objeto producto
	  	 */
		buscar: function(producto){
		  console.info("hay esta cantidad de productos en la coleccion "+this.productos.length);
		  
		  prod = this.productos.find(function(p){	  
				return (p.getId() == producto.getId());
		  });
		  
	 	  if(prod){
	 		 return prod; 
		  }else{ 
			  return null;
		  }
	  	},
	  
	  
	  	contarProductoEnComanda: function(producto){
	  		var contador = 0;
	  		this.productos.each(function(p){
	  			console.info("estoy adentro del each e contarProducto: el id de p es: "+p.getId()+" el Id de producto es: "+producto.getId()+" el contador interno va por: "+contador);
	  			if(p.getId() == producto.getId()) contador++;
	  		});
	  		console.info("hay "+contador+" productos con el nombre: "+producto.getName());
	  		return contador;
	  	}
	};

