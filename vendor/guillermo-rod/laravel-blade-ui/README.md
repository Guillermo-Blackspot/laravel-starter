# Laravel Blade Ui

A set of components to utilize in your Laravel Blade views supporting custom themes

### Themes

This package is useful to save development time in Laravel, since it provides a list of basic components to start a web development like form inputs, modal, table, etc..

The currently available theme is bootstrap4

### Switching between themes
Just need add the "theme" attribute in any `<x-bui-component />`
```
	<x-bui-button
		text="Send"
		theme="bootstrap4"
	/>	
	
	<x-bui-button
		text="Send"
		theme="tailwind"
	/>	
	
	<x-bui-button
		text="Send"
		theme="your-custom-theme"
	/>	
```
### Components

### Alerts

```
	<x-bui-alert
		class="alert-success"
		text="Alerta"
		close-button="false"
	/>		
	
	<x-bui-alert
		class="alert-danger"
		flash="error" //session flash
	/>
```

### Buttons

```
	<x-bui-button
		class="btn-primary"
		text="Modal"
		icon="dripicons-plus"
	/>
	
	<x-bui-button
		class="border-primary"
		style="background-color: #fff; color: #000;"
		text="User"
		html-icon='<span class="material-icons">account_circle</span>'
	/>
```

### Loaders
```
	<x-bui-loading 
		type="circle" 
		color="#000"
		/>
	
	type  = [circle (default)| square | clock | dots-jumping | dots-fading | bars]
	color = #hex
```

### Modals

```
	<x-bui-simple-modal
		id="modal-id"
		title="soy el titulo"
		dialog-class="modal-lg"
		body-class="mt-3">
		<p>Lorem ipsum dolor...</p> //$slot
	</x-simple-modal>
```    

You can access to all levels of the modal with the especial attributes using the same syntax:

	-> container  
		-> dialog 
			-> header
				-> title 
				-> close				
			-> body 
			-> footer

	// container-class=""
	   $level-class="some-class-to-add"   

	// :container-jattributes="[
		'data-toggle' => 'tooltip'
	]"
	
       :$level-jattributes="['attribute' => 'value']"
    

### Forms
You can use 3 components input,  textarea, select

```
<x-bui-linear-input
	label="Ingrese su nombre"
	required="false" // generates the word "optional" in the placeholder
/>


<x-bui-linear-textarea
	label="Ingrese una descripción"
	required="true" // generates the word "required" and "*" in the placeholder and label
/>


<x-bui-linear-select 
	label="Ingrese su nombre" 
	name="color">
	<x-slot name="options">
		@foreach (['rojo','azul','amarilllo'] as  $item)
			<option  value="{{  $item  }}">{{  $item  }}</option>
		@endforeach
	</x-slot>
</x-bui-linear-select>
```

### Tables
The default bootstrap4 table internally has the table-responsive class, but you can change using the "container-class" or "the container-jattributes"

```
<x-bui-table  
	class="table-bordered"
	thead-class="thead-light"
>	
	<x-slot  name="head">
		<tr>
			<th>Id</th>
			<th>Name</th>
		</tr>
	</x-slot>
	<x-slot  name="body">
		<tr>
			<td>1</td>
			<td>Guillermo</td>
		</tr>
	</x-slot>
</x-bui-table>
```

### Flexibility

You can use js frameworks with the components, this is a simple example with the "textarea" component and Alphinejs
```
<x-bui-linear-textarea
	label="Alphine scripts"
	required="true:text" // genereates the "required" placeholder but the attribute "required=required" will not added
	placeholder="Type something, "
	:container-jattributes="[
		'x-data'  =>  '{
			open: false,
			message: \'\'
		}'
	]"
	:textarea-jattributes="[
		'x-on:click' =>  'open = true',
		'x-model'    =>  'message'
	]">
	<div x-show="open">
		Mensaje: <span x-text="message"></span> // $slot
	</div>
</x-bui-linear-textarea>
```

### Author 

Guillermo Rodriguez | guillermo.rodriguez.developer@gmail.com

### Version 

v0.1.0-bootstrap4