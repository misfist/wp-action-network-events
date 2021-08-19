import { 
    registerBlockType,
    registerBlockCollection
} from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';

/**
 * Register Custom Block Collection
 */
registerBlockCollection( 'wp-action-network-events', { 
    title: __( 'Action Network Events', 'wp-action-network-events' ),
	icon: 'calendar-alt'
} );

import * as date from './eventDate';
import * as location from './eventLocation';
import * as time from './eventTime';
import * as query from './eventQuery';

const blocks = [
    date,
	location,
	time,
	query
];

/**
 * Function to register an individual block.
 *
 * @param {Object} block The block to be registered.
 *
 */
 const registerBlock = ( block ) => {
	if ( ! block ) {
		return;
	}

	const { name, settings } = block;

	registerBlockType( name, {
		...settings,
	} );
};

/**
 * Function to register blocks
 */
 export const registerBlocks = () => {
	blocks.forEach( registerBlock );
};

registerBlocks();