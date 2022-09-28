import React, { Component } from 'react';
import './note.css';
import  PropTypes from 'prop-types';

class Note extends Component {
    constructor(props){
        
    super(props);

    this.noteContent = props.noteContent;

    this.noteId = props.noteId;

    this.handleRemoveNote = this.handleRemoveNote.bind(this);

    // this.message = "hello from the note component!"
    }

    handleRemoveNote(id){
        this.props.removeNote(id);
    }
    render(props){
        return(
            <div className="note fade-in">
                {/* <h1>{ this.message }</h1> */}
                <span className="closebtn" 
                    onClick={() => this.handleRemoveNote(this.noteId)}>
                        &times;
                </span>
                <p className="noteContent"> { this.noteContent }</p>

            </div>
        )
    }
}

Note.prototype = {
    noteContent : PropTypes.string
}
export default Note;