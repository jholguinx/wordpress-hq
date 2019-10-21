import React , { Component } from 'react';
import Autosuggest from 'react-autosuggest';

class SuggestionInput extends Component{
    constructor(props){
        super(props);
        this.state = {
            inputProps: {
                placeholder: '',
                value: '',
                onChange: this.onChange.bind(this),
                name: '',
                id:''
            },
        };
    }
    componentDidMount() {
        this.setState({
            inputProps: {
                ...this.state.inputProps,
                placeholder: this.props.placeholder,
                name: this.props.name,
                id: this.props.id
            },
        });
    }

    // Autosuggest will call this function every time you need to update suggestions.
    // You already implemented this logic above, so just use it.
    onSuggestionsFetchRequested({ value }){
        return value;
    };

    // Autosuggest will call this function every time you need to clear suggestions.
    onSuggestionsClearRequested(){
        this.props.clearSuggestions()
    };

    onChange(event){
        if(event.target.value){
            this.setState({
                inputProps: {
                    ...this.state.inputProps,
                    value: event.target.value
                },
            });
            this.props.onChangeInput(event.target.value);
        }
    }

    getSuggestionValue(suggestion){
        return suggestion.description;
    }
    shouldRenderSuggestions(value) {
        if(value){
            return value.trim().length > 2;
        }
    }
    renderSuggestion(suggestion, { query, isHighlighted }){
        if(suggestion){
            return(
                <div>
                    <p>{suggestion.description}</p>
                </div>
            );
        }

    }
    onSuggestionSelected(event,{suggestion}) {
        this.props.onClickSuggestion(suggestion);
    }
    render(){
        return(
            <Autosuggest
                onSuggestionsFetchRequested={this.onSuggestionsFetchRequested.bind(this)}
                onSuggestionsClearRequested={this.onSuggestionsClearRequested.bind(this)}
                getSuggestionValue={this.getSuggestionValue.bind(this)}
                renderSuggestion={this.renderSuggestion.bind(this)}
                onSuggestionSelected={this.onSuggestionSelected.bind(this)}
                shouldRenderSuggestions={this.shouldRenderSuggestions.bind(this)}
                inputProps={this.state.inputProps}
                suggestions={this.props.suggestions}
            />
        );
    }
}
export default SuggestionInput;