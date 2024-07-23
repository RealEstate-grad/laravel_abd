import pandas as pd
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import cosine_similarity
import sys
import json
# Index Model: Vector space model
class Indexer:

    def __init__(self, documents_df):
        # Concatenate the features into a single text feature
        documents_df['combined_features'] = documents_df['description'].astype(str) + ' ' + documents_df['address'] + ' ' + documents_df['realestate_num'] + ' ' + documents_df['space'] + ' ' + documents_df['floor'] + ' ' + documents_df['bathroom'] + ' ' + documents_df['bedroom'] + ' ' + documents_df['price'] + ' ' + documents_df['status']
        
        # Create a TF-IDF vectorizer
        self.tfidf_vectorizer = TfidfVectorizer()
        # Fit the documents and transform
        self._index = self.tfidf_vectorizer.fit_transform(documents_df['combined_features'])

    def get_index(self):
        return self._index

    def vectorize(self, sentence):
        if isinstance(sentence, str):
            qry = pd.DataFrame([{"text": sentence}])
        else:
            qry = sentence
        return self.tfidf_vectorizer.transform(qry['text'])


class Retriever:

    def retrieve(self, query_vec, index_model):
        cosine_similarities = cosine_similarity(query_vec, index_model.get_index())
        results = pd.DataFrame(
            [{'ID': i + 1, 'score': cosine_similarities[0][i]}
             for i in range(len(cosine_similarities[0]))]
        ).sort_values(by=['score'], ascending=False)
        return results[results["score"] > 0]


# Load user data from JSON input
def load_user_data():
    user_data = sys.argv[1]
    return user_data

# Main function to execute recommendation algorithm

def main():
    # Load realestate descriptions data from file
    with open(sys.argv[2], 'r') as f:
        realestate_data = json.load(f)
    # Load realestate  data into a DataFrame
   realestate_df = pd.DataFrame(realestate_data)

    # Create indexer and retriever objects
    vsm = Indexer(realestate_df)
    rt = Retriever()

    # Process user data (if needed)
    user_data = load_user_data()
    user_vector = vsm.vectorize(user_data)

    # Retrieve realestate recommendations
    recommendations = rt.retrieve(user_vector, vsm)
    print(recommendations.head())

if __name__ == "__main__":
    main()