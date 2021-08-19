/**
 * WordPress dependencies
 */
import { postDate as icon } from '@wordpress/icons';
import { __ } from '@wordpress/i18n';

/**
 * Internal dependencies
 */
import metadata from './block.json';
import Edit from './edit';

// registerBlockType( metadata.name, {
//     edit: Edit,
//     icon
// } );

const { name, category } = metadata;

const settings = {
	icon,
	edit: Edit,
};

export { name, category, settings };