import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { connect } from 'react-redux';
import * as actions from '../actions';
import _ from 'lodash';

import SearchResultComponent from '../components/SearchResultComponent';

const rootElement = document.getElementById('node-map-component-root');
const trans = {};

let map = null;
let addedNodes = [];
let addedReko = [];
let visibleLatLng = [];

class NodeMapContainer extends Component {
    constructor(props) {
        super(props);

        this.debouncedSearch = this.debouncedSearch.bind(this);
        this.getNodePreview = this.getNodePreview.bind(this);
        this.onSelect = this.onSelect.bind(this);

        this.state = {
            searchString: '',
            action: '',
            position: {}
        }
    }

    componentDidMount() {
        const { dispatch } = this.props;
        actions.fetchUserLocation(dispatch);
        this.createMap();
    }

    componentDidUpdate(prevProps, prevState) {
        const { dispatch } = this.props;

        if (this.props.userLocation !== prevProps.userLocation) {
            // map.panTo(new L.LatLng(this.props.userLocation.lat, this.props.userLocation.lon));
            map.setView([this.props.userLocation.lat, this.props.userLocation.lon], 10);
            actions.fetchContent(dispatch, this.getSanitizedBoundsObject(map.getBounds()));
        }

        if (this.props.nodes !== prevProps.nodes) {
            this.createMarkers();
        }
    }

    createMap() {
        let that = this;

        map = L.map(this.refs.map, {
            center: [56, 13],
            zoom: 8,
            maxZoom: 15,
            zoomControl: false,
            scrollWheelZoom: false,
        });

        L.control.zoom({
            position:'bottomright'
       }).addTo(map);

        let mapboxUrl = 'https://api.mapbox.com/styles/v1/davidajnered/cjbhze779dawz2sp6vvsw4ktq/tiles/256/{z}/{x}/{y}?access_token=pk.eyJ1IjoiZGF2aWRham5lcmVkIiwiYSI6ImNpenZxcWhoMzAwMGcyd254dGU4YzNkMjQifQ.DJncF9-KJ5RQAozfIwlKDw';

        let tileLayer = L.tileLayer(mapboxUrl, {
        	attribution: '© <a href="https://www.mapbox.com/map-feedback/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
        	subdomains: 'abcd',
        	maxZoom: 18
        });

        tileLayer.addTo(map);

        map.on('zoomend dragend', function(event) {
            let bounds = map.getBounds();
            that.createMarkersOnEvent(bounds);
        });

        this.setState({
            action: 'mapCreated',
        });

        // First load
        this.createMarkersOnEvent(map.getBounds());
    }

    createMarkersOnEvent(bounds) {
        const { dispatch } = this.props;
        visibleLatLng = []; // Reset

        // No need to double fetch content when map is created
        if (this.state.action !== 'mapCreated') {
            actions.fetchContent(dispatch, this.getSanitizedBoundsObject(bounds));
        }

        this.setState({action: null, position: {}}); // Reset
    }

    createMarkers() {
        let that = this;

        let markers = L.markerClusterGroup({
            iconCreateFunction: function(cluster) {
                return L.divIcon({ html: `<div class="leaflet-cluster-marker">${cluster.getChildCount()}</div>` });
            },
            showCoverageOnHover: false,
            spiderLegPolylineOptions: { opacity: 0 }
        });

        let iconBase = {
            html: '<i class="fa fa-map-marker"></i>',
            iconSize: [50, 50],
            // iconAnchor: [0, 50],
            // popupAnchor: [-25, -25]
        };

        let nodeIcon = L.divIcon(_.merge(iconBase, {className: 'map-marker node'}));
        let rekoIcon = L.divIcon(_.merge(iconBase, {className: 'map-marker reko'}));

        _(this.props.nodes).each((node, index) => {
            if (addedNodes.indexOf(node.id) === -1) {
                let marker = L.marker([node.location.lat, node.location.lng], {icon: nodeIcon});
                let popup = document.createElement('div');
                ReactDOM.render(that.getNodePreview(node), popup);
                marker.bindPopup(popup);
                markers.addLayer(marker);
                addedNodes.push(node.id);
            }
        });

        _(this.props.reko).each((reko, index) => {
            if (addedReko.indexOf(reko.id) === -1) {
                let marker = L.marker([reko.location.lat, reko.location.lng], {icon: rekoIcon});
                let popup = document.createElement('div');
                ReactDOM.render(that.getRekoPreview(reko), popup);
                marker.bindPopup(popup);
                markers.addLayer(marker);
                addedReko.push(reko.id);
            }
        });

        map.addLayer(markers);

        if (this.state.action === 'search' || this.state.action === 'mapCreated') {
            this.setBounds();
        }
    }

    setBounds() {
        visibleLatLng.push([this.state.position.lat, this.state.position.lng]);

        _(this.props.nodes).each((node) => {
            visibleLatLng.push([node.location.lat, node.location.lng]);
        });

        let bounds = new L.LatLngBounds(visibleLatLng);
        map.fitBounds(bounds);
    }

    getSanitizedBoundsObject(bounds) {
        // Check what type of object is passed
        // Map bounds or place bounding box
        if (bounds._southWest) {
            return {
                bounds: {
                    sw: {lat: bounds._southWest.lat, lng: bounds._southWest.lng},
                    ne: {lat: bounds._northEast.lat, lng: bounds._northEast.lng}
                }
            }
        } else if (_.isArray(bounds) && bounds.length === 4) {
            return {
                bounds: {
                    sw: {lat: bounds[0], lng: bounds[2]},
                    ne: {lat: bounds[1], lng: bounds[3]}
                }
            }
        }
    }

    getNodePreview(node) {
        return (
            <div className='card-node-container my-5'>
                <div className='node-image image p-3' style={{backgroundImage: 'url(/images/shutterstock_271622087.jpg)'}}>
                    <span className='btn btn-dark'>
                        <i className='fa fa-clock-o' aria-hidden='true' /> {trans[node.delivery_weekday]} {node.delivery_time}
                    </span>
                </div>

                <div className='node-content p-3'>
                    <h4 className='mb-0'>{node.name}</h4>
                    <small>{node.address} {node.zip} {node.city}</small>

                    <p className='mt-3'>
                        <small>{trans.welcome_to} {node.name}</small>
                    </p>

                    <hr/>
                    <a className='rc text-uppercase' href={node.permalink_relationship.url}>{trans.visit_node}</a>
                    <i className='product-items-share fa fa-share icon-38 float-right' aria-hidden='true'></i>
                </div>
            </div>
        );
    }

    getRekoPreview(reko) {
        return (
            <div className='map-preview'>
                <a href={reko.link} target='_blank' className='header'>
                    <h3>{reko.name}</h3>
                </a>
                <div className='body-text'>
                    <p><a href={reko.link} target='_blank'>{trans.link_to_fb} {reko.name}</a></p>
                    <p className='reko-fb-info'>
                        <img src='/css/leaflet/images/reko-icon.png' />
                        <span>{trans.grey_map_marker_info}</span>
                    </p>
                </div>
            </div>
        );
    }

    getMapLoader() {
        return (
            <div className='map-loader'>
                <img src="/images/loader.svg" />
            </div>
        );
    }

    onSelect(place) {
        const { dispatch } = this.props;

        visibleLatLng = []; // Reset
        map.panTo(new L.LatLng(place.lat, place.lon));

        this.setState({
            searchString: place.display_name,
            action: 'search',
            position: {
                lat: place.lat,
                lng: place.lon
            }
        });

        actions.fetchContent(dispatch, this.getSanitizedBoundsObject(place.boundingbox));
    }

    search(event) {
        event.persist();
        this.setState({searchString: event.target.value})
        this.debouncedSearch(event);
    }

    debouncedSearch(event) {
        const { dispatch } = this.props;
        actions.searchGeo(dispatch, event.target.value);
    }

    render() {
        let loader = (this.props.fetching) ? this.getMapLoader() : null;

        let searchResults = null;
        if (this.props.searchResults) {
            searchResults = <SearchResultComponent data={this.props.searchResults} onSelect={this.onSelect}/>;
        }


        return (
            <div>
                <div className='row no-gutters map-search mb-5'>
                    <div className='col-12 col-md-6'>
                        <div className='input-group'>
                            <span className="input-group-addon"><i className="fa fa-search" /></span>
                            <input value={this.state.searchString} type="text" className="form-control" placeholder="@lang('Find node near your in map')" onChange={this.search.bind(this)} />
                        </div>
                        {searchResults}
                    </div>
                </div>
                <div className='map-holder' ref='map' style={{height: '70vh'}}>{loader}</div>
            </div>
        );
    }
}

function mapStateToProps(state) {
    return state;
}

export default connect(mapStateToProps)(NodeMapContainer);
