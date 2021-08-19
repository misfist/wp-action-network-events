/**
 * WordPress dependencies
 */
 import { 
	Panel, 
	PanelBody, 
	PanelRow,
	QueryControls,
	SelectControl,
	Spinner
} from '@wordpress/components';
import { 
	useEntityProp,
	store as coreStore
} from '@wordpress/core-data';
import { 
	useState, 
	useMemo
} from '@wordpress/element';
import { useSelect } from '@wordpress/data';
import { 
	__experimentalGetSettings,
	 dateI18n 
} from '@wordpress/date';
import { 
	InnerBlocks, 
	InspectorControls, 
	useBlockProps
} from '@wordpress/block-editor';
import { more } from '@wordpress/icons';
import { __, sprintf } from '@wordpress/i18n';

import metadata from './block.json';
const { attributes } = metadata;

const Edit = ( { 
	attributes: { 
		queryId,
		query,
		layout
	}, 
	setAttributes
 } ) => {

	const QUERY_DEFAULTS = attributes.query.default;
	const { taxonomy, postType } = attributes.query;
	
	const TermSelector = () => {
		const terms = useSelect( ( select ) => {
			return select( 'core' ).getEntityRecords( 'taxonomy', taxonomy );
		}, [] );

		const setTerm = ( term ) => {
			setAttributes( {
				query: {
					"event-tags": term
				}
			} )
		}

		if( !terms || !terms.length ) {
			return <Spinner />;
		}

		const options = terms.map( ( { id, name } ) => ( { value: id, label: name } ) );

		return (
			<>
				<SelectControl
					label={ __( 'Tag', 'wp-action-network-events' ) }
					options={ [ { value: "", label: __( 'Select a Tag', 'wp-action-network-events' ) }, ...options ] || [ { value: "", label: __( 'Loading...', 'wp-action-network-events' ) } ] }
					onChange={ setTerm }
					value={ query['event-tags'] }
				/>
			</>
		);
	};

	const EventQueryControl = () => {
		const [ query, setQuery ] = useState( QUERY_DEFAULTS );
		const { orderby, order, perPage } = query;
	
		const updateQuery = ( newQuery ) => {
			setQuery( { ...query, ...newQuery } );
		};
	
		return (
			<QueryControls
				{ ...{ orderby, order, perPage } }
				onOrderByChange={ ( newOrderBy ) => updateQuery( { orderby: newOrderBy } ) }
				onOrderChange={ ( newOrder ) => updateQuery( { order: newOrder } ) }
				onNumberOfItemsChange={ ( newNumberOfItems ) =>
					updateQuery( { perPage: newNumberOfItems } )
				}
			/>
		);
	};

	const OrderSelector = () => {

		const options = [
			{
				value: "",
				label: __( 'Order By', 'wp-action-network-events' )
			},
			{
				value: "meta_key",
				label: __( 'Event Date', 'wp-action-network-events' )
			},
			{
				value: "title",
				label: __( 'Title', 'wp-action-network-events' )
			}
		];

		const setOrderBy = ( orderBy ) => {
			setAttributes( {
				query: {
					"orderby": orderBy
				}
			} )
		}

		if( !orderByOptions || !orderByOptions.length ) {
			return <Spinner />;
		}

		return (
			<>
				<SelectControl
					label={ __( 'Order', 'wp-action-network-events' ) }
					options={ options }
					onChange={ setOrderBy }
					value={ query.orderby }
				/>
			</>
		);
	};


	const SettingsPanel = () => (
		<PanelBody title={ __( 'Query Options', 'wp-action-network-events' ) } initialOpen={ true }>
			<PanelRow>
				<TermSelector />
			</PanelRow>
		</PanelBody>
	);

	const Posts = () => {
		const posts = useSelect( ( select ) => {
			// console.log( 'Query', query );
			return select( 'core' ).getEntityRecords( 'postType', postType, query );
		} );

		if( !posts || !posts.length ) {
			return <Spinner />
		}

		console.log( posts );

		return (
			<>
				{ posts.map( post => {
					return (
						<article className={`${post.type}`} key={post.id}>
							<h2 className="event__title"><a link={ post.link } rel="bookmark" dangerouslySetInnerHTML={{ __html: post.title.rendered }} /></h2>
							<div className="event__date">
								<time datetime={ post.meta?.["_start_date"] }>{ post.meta?.["_start_date"] }</time>
							</div>
							<div className="event__time">
								<time datetime={ post.meta?.["_start_date"] }>{ post.meta?.["_start_date"] }</time>
							</div>
							<div className="event__location" dangerouslySetInnerHTML={{ __html: post.meta?.["_location_venue"] }}></div>
						</article>
					);
				}) }
			</>
		)
	}


	// if( posts ) {
	// 	console.log( posts );
	// }

	const blockProps = useBlockProps();

	return (
		<>
		<InspectorControls>
			<SettingsPanel />
			<EventQueryControl />
		</InspectorControls>

		<div { ...blockProps }>
			<Posts />
		</div>
		</>
	);
};

export default Edit;
