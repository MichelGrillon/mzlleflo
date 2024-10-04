( function( blocks, element, serverSideRender ) {
    var el = element.createElement;

    blocks.registerBlockType( 'art-gallery/artwork-archives', {
        title: 'Archives des Créations',
        icon: 'archive',
        category: 'widgets',
        edit: function() {
            return el( serverSideRender, {
                block: 'art-gallery/artwork-archives',
                attributes: {}
            } );
        },
        save: function() {
            return null;
        }
    } );

    blocks.registerBlockType( 'art-gallery/art-categories', {
        title: 'Catégories d\'Art',
        icon: 'category',
        category: 'widgets',
        edit: function() {
            return el( serverSideRender, {
                block: 'art-gallery/art-categories',
                attributes: {}
            } );
        },
        save: function() {
            return null;
        }
    } );

    blocks.registerBlockType( 'art-gallery/latest-artworks', {
        title: 'Derniers Artworks',
        icon: 'format-image',
        category: 'widgets',
        attributes: {
            numberOfPosts: {
                type: 'number',
                default: 5
            },
            layout: {
                type: 'string',
                default: 'vertical'
            }
        },
        edit: function( props ) {
            var attributes = props.attributes;

            function onChangeNumberOfPosts( newNumberOfPosts ) {
                props.setAttributes( { numberOfPosts: newNumberOfPosts } );
            }

            function onChangeLayout( newLayout ) {
                props.setAttributes( { layout: newLayout } );
            }

            return el( 'div', {},
                el( serverSideRender, {
                    block: 'art-gallery/latest-artworks',
                    attributes: attributes
                } ),
                el( 'p', {},
                    el( 'label', { for: 'number-of-posts' }, 'Nombre d\'articles: ' ),
                    el( 'input', {
                        type: 'number',
                        id: 'number-of-posts',
                        value: attributes.numberOfPosts,
                        onChange: function( event ) {
                            onChangeNumberOfPosts( parseInt( event.target.value, 10 ) );
                        }
                    } )
                ),
                el( 'p', {},
                    el( 'label', { for: 'layout' }, 'Mise en page: ' ),
                    el( 'select', {
                        id: 'layout',
                        value: attributes.layout,
                        onChange: function( event ) {
                            onChangeLayout( event.target.value );
                        }
                    },
                    el( 'option', { value: 'vertical' }, 'Vertical' ),
                    el( 'option', { value: 'horizontal' }, 'Horizontal' )
                    )
                )
            );
        },
        save: function( props ) {
            return el( 'div', {
                'data-number-of-posts': props.attributes.numberOfPosts,
                'data-layout': props.attributes.layout
            } );
        }
    } );
} )(
    window.wp.blocks,
    window.wp.element,
    window.wp.serverSideRender
);
