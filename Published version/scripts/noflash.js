// Hide objects to prevent flickering when recreating the objects
document.write( '<style type="text/css" id="ieflashfix">' );
document.write( 'object { display: none }' );
document.write( '</style>' );

// Recreate and reveal the hidden objects
window.attachEvent( "onload", function()
{
    // Recreate the objects
    var objects = document.getElementsByTagName( "object" );
    for ( var i = 0; i < objects.length; i++ )
    {
        var object = objects.item(i);

        // Fix flash object
        if ( object.type == "application/x-shockwave-flash" )
        {
            if ( object.getAttribute("data") )
            {
                object.removeAttribute( "data" );
            }
            object.outerHTML = object.outerHTML;
        }
    }

    // Reveal the objects by removing the stylesheet created by document.write
    var stylesheet = document.getElementById("ieflashfix");
    stylesheet.parentNode.removeChild( stylesheet );
} );