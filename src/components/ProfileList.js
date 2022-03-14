import React, { Component } from 'react';
import axios from 'axios';
import ProfileCard from './ProfileCard.js'
import TagsSelector from './TagsSelector.js'
import Stack from 'react-bootstrap/Stack';
import Container from 'react-bootstrap/Container';
import Row from 'react-bootstrap/Row';
import Col from 'react-bootstrap/Col';
import CardGroup from 'react-bootstrap/CardGroup';



export default class ProfileList extends Component {

    state = {
        error: null,
        isLoaded: false,
        profiles: [],
        tags:[]
    };

    componentWillMount() {

        let domain = "https://ivfsf.narramur.de/";

        axios.get(domain+"wp-json/wp/v2/profile").then(
          result => {
              console.log(result)
            //  let json = JSON.parse(result.data)
            //  console.log(json)
            this.setState({
              isLoaded: true,
              profiles: result.data
            });
          },
          // Note: it's important to handle errors here
          // instead of a catch() block so that we don't swallow
          // exceptions from actual bugs in components.
          error => {
            this.setState({
              isLoaded: true,
              error
            });
          }
          );

          axios.get(domain+"wp-json/wp/v2/profile_tags").then( // wp-content/plugins/ivfsf-mitglieder/profile_tags.json
            result => {
                console.log(result)
                //let json = JSON.parse(result.data)
                //console.log(json)
              this.setState({
                tagsIsLoaded: true,
                tags: result.data
              });
            },
            // Note: it's important to handle errors here
            // instead of a catch() block so that we don't swallow
            // exceptions from actual bugs in components.
            error => {
              this.setState({
                tagsIsLoaded: true,
                error
              });
            }
            );
          
      }


      render() {
        const { error, isLoaded, tagsIsLoaded, profiles, tags } = this.state;
        if (error) {
          return <div>Error: {error.message}</div>;
        } else if (!isLoaded || !tagsIsLoaded) {
          return <div>Loading...</div>;
        } else {
          return (
       <Container>
            <Row xs={1} md={2} className="g-2">
                {profiles.map((profile) => (
                    <Col key={profile.id}>
                        <ProfileCard profile = {profile} tags={tags}/>
                    </Col>
                ))}
            </Row>
        </Container>
        );
    }}}
